<?php

class Todo extends Controller{

    public function  __construct() {
        // Piesaista modeli
        $this->cardModel = $this->model('Card');

        // Izveido csrf atslēgu
        session_start();

        if (empty($_SESSION['key'])) {
            $_SESSION['key'] = bin2hex(random_bytes(32));
        } 

    }

    public function index() {
        // Atrod visas kārtis
        $cards = $this->cardModel->getCards();

        // Izveido masīvu ar visu kartiņu vecumiem teksta formātā.
        $cardAge = [];
        foreach ($cards as $card) {
            $cardAge[$card->card_id] = $this->cardModel->time_elapsed_string($card->created_at);
        }
        
        // Datus saglabā vienā masīvā $data un padod uz skatu
        $data = [
            'cards' => $cards,
            'cardAge' => $cardAge,
        ];
        $this->view('todo/index', $data);
    }

    public function create() {
        
        // Sagatavo datu masīvu
        $data = [
            'title' => '',
            'description' => '',
            'titleError' => '',
            'descriptionError' => '',
        ];

        // Ja tiek saņemts post pieprasījums (nospiesta poga un adresēta šeit)
        if($_SERVER['REQUEST_METHOD']=='POST') {

            // Pārbauda vai padotā un šeit ģenerētā csrf atslēga sakrīt
            if (!empty($_POST['csrf'])) {
                if (!hash_equals($_SESSION['key'], $_POST['csrf'])) {
                    die('CSRF atslēgas nesakrīt!');
                }
            }

            // Pārbauda un attīra ievaddatus
            $input = trim(INPUT_POST);
            $input = stripslashes($input);
            $input = filter_input_array($input, FILTER_SANITIZE_STRING);
            
            // Ievieto jaunos datus
            $data = [
                'title' => trim($input['title']),
                'description' => trim($input['description']),
                'titleError' => '',
                'descriptionError' => '',
            ];

            // Validē jaunos datus, ja kaut kas neatbalst nosacījumiem, atgriež brīdinājumu
            if (empty($data['title'])) {
                $data['titleError'] = 'Lūdzu ievadiet virsrakstu';
            } elseif (strlen($data['title'])>255){
                $data['titleError'] = 'Virsraksta lauks nedrīkst pārsniegt 255 simbolus';
            } elseif (strlen($data['description'])>255){
                $data['descriptionError'] = 'Apraksta lauks nedrīkst pārsniegt 255 simbolus';
            } else {

                // Ja dati veiksmīgi validējas, tos saglabā datubāzē un atgriež uz galveno skatu (index), ja nē tad atgriež brīdinājuma ziņu
                if ($this->cardModel->saveCard($data)) {
                    header('location:'. URLROOT . '/todo/index');
                } else {
                    die('kaut kas nogāja greizi, mēģiniet vēlreiz.');
                }
            }
        }
        
        // Atgriež kartiņas izveidošanas skatu
        $this->view('todo/create', $data);
    }


    public function edit($id) {
        
        // Atrod kartiņas objektu
        $post = $this->cardModel->findCardById($id);
        
        // Saglabā kartiņas objektu, kā $post, lai padotu uz skatu
        $data = [
            'post' => $post,
            'titleError' => '',
            'descriptionError' => '',
        ];

        // Ja tiek saņemts post pieprasījums (nospiesta poga un adresēta šeit)
        if($_SERVER['REQUEST_METHOD']=='POST') {

            // Pārbauda vai padotā un šeit ģenerētā csrf atslēga sakrīt
            if (!empty($_POST['csrf'])) {
                if (!hash_equals($_SESSION['key'], $_POST['csrf'])) {
                    die('CSRF atslēgas nesakrīt!');
                }
            }

            // Attīra ievaddatus no potenciāliem uzbrukumiem un kaitēkļiem
            $data = trim(INPUT_POST);
            $data = stripslashes($data);
            $data = filter_input_array($data, FILTER_SANITIZE_STRING);

            // Saglabā ievaddatus masīvā, kopā ar pārējiem datiem
            $data = [
                'post' => $post,
                'id' => $id,
                'title' => trim($data['title']),
                'description' => trim($data['description']),
                'titleError' => '',
                'descriptionError' => '',
            ];

            // Validē jaunos datus, ja kaut kas neatbalst nosacījumiem, atgriež brīdinājumu
            if (empty($data['title'])) {
                $data['titleError'] = 'Virsraksta lauks nedrīkst būt tukšs';
            } elseif (strlen($data['title'])>255){
                $data['titleError'] = 'Virsraksta lauks nedrīkst pārsniegt 255 simbolus';
            } elseif (strlen($data['description'])>255){
                $data['descriptionError'] = 'Apraksta lauks nedrīkst pārsniegt 255 simbolus';
            } else {

                // Ja dati veiksmīgi validējas, tos atjaunina datubāzē un atgriež uz galveno skatu (index), ja nē tad atgriež brīdinājuma ziņu
                if ($this->cardModel->updateCard($data)) {
                    header('location:'. URLROOT . '/todo/index');
                } else {
                    die('kaut kas nogāja greizi, mēģiniet vēlreiz.');
                }
            }
        }
        
        // Atgriež kartiņas izveidošanas skatu
        $this->view('todo/edit', $data);
    }
    
    public function delete($id) {

        // Ja tiek saņemts post pieprasījums (nospiesta poga un adresēta šeit)
        if($_SERVER['REQUEST_METHOD']=='POST') {

            // Ja atrod un var veiksmīgi izdzēst kartiņu to izdara un atgriež uz to pašu lapu (atjauno lapu)
            if ($this->cardModel->deleteCard($id)) {
                header('location:'. URLROOT . '/todo/index');
            } else {

                // Ja neizdodas izdzēst, tad atgriež ziņu
                die('Nevarēja izdzēst pierakstu, lūdzu mēģiniet vēlreiz');
            }
        }
    }

    public function toggleCheckbox($id) {

        // Atrod kartiņu, kurai jāizmain atķeksēšanas statuss
        $card = $this->cardModel->findCardById($id);

        // Saglabā jau esošos datus, bet atķeksēšanas vietā atgriež pretējo vērtību (atķesēts -> neatķesēts un neatķeksēts -> atķeksēts)
        $data = [
            'id' => $card->card_id,
            'title' => $card->title,
            'description' => $card->description,
            'isChecked' => !$card->isChecked
        ];

        // Funkcija, kur atjaunina kartiņas informāciju
        $this->cardModel->updateCard($data);
    }
}
?>