<?php

class Todo extends Controller{

    public function  __construct() {
        // Piesaista modeli
        $this->cardModel = $this->model('Card');
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
        if($this->postMethod()) {

            // Pārbauda vai padotā un šeit ģenerētā csrf atslēga sakrīt
            $this->validateCSRF();

            // Pārbauda un attīra ievaddatus
            $input = $this->sanitizeInput(INPUT_POST);
            
            // Ievieto jaunos datus
            $data['title'] = $input['title'];
            $data['description'] = $input['description'];

            // Validē jaunos datus
            $data = $this->findInputErrors($data);

            // Validē jaunos datus, ja kaut kas neatbalst nosacījumiem, atgriež brīdinājumu
            if ($this->checkIfInputError($data)) {

                // Ja dati veiksmīgi validējas, tos saglabā datubāzē un atgriež uz galveno skatu (index), ja nē tad atgriež brīdinājuma ziņu
                if ($this->cardModel->saveCard($data)) {
                    $this->returnToTodoIndex();
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
        // var_dump($post); die();
        $data = [
            'card_id' => $post->card_id,
            'title' => $post->title,
            'description' => $post->description,
            'titleError' => '',
            'descriptionError' => '',
        ];

        // Ja tiek saņemts post pieprasījums (nospiesta poga un adresēta šeit)
        if($this->postMethod()) {

            // Pārbauda vai padotā un šeit ģenerētā csrf atslēga sakrīt
            $this->validateCSRF();

            // Attīra ievaddatus no potenciāliem uzbrukumiem un kaitēkļiem
            $input = $this->sanitizeInput(INPUT_POST);

            // Saglabā ievaddatus masīvā, kopā ar pārējiem datiem
            $data['title'] = $input['title'];
            $data['description'] = $input['description'];

            // Validē jaunos datus, ja kaut kas neatbalst nosacījumiem, atgriež brīdinājumu
            $data = $this->findInputErrors($data);
            
            // Validē jaunos datus, ja kaut kas neatbalst nosacījumiem, atgriež brīdinājumu
            if ($this->checkIfInputError($data)) {

                // Ja dati veiksmīgi validējas, tos atjaunina datubāzē un atgriež uz galveno skatu (index), ja nē tad atgriež brīdinājuma ziņu
                if ($this->cardModel->updateCard($data)) {
                    $this->returnToTodoIndex();
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
        if($this->postMethod()) {

            // Ja atrod un var veiksmīgi izdzēst kartiņu to izdara un atgriež uz to pašu lapu (atjauno lapu), ja nevar, atgriež paziņojumu
            if ($this->cardModel->deleteCard($id)) {
                $this->returnToTodoIndex();
            } else {
                die('Nevarēja izdzēst pierakstu, lūdzu mēģiniet vēlreiz');
            }
        }
    }

    public function toggleCheckbox($id) {

        // Atrod kartiņu, kurai jāizmain atķeksēšanas statuss
        $card = $this->cardModel->findCardById($id);

        // Saglabā jau esošos datus, bet atķeksēšanas vietā atgriež pretējo vērtību (atķesēts -> neatķesēts un neatķeksēts -> atķeksēts)
        $data = [
            'card_id' => $card->card_id,
            'title' => $card->title,
            'description' => $card->description,
            'isChecked' => !$card->isChecked
        ];

        // Funkcija, kur atjaunina kartiņas informāciju
        $this->cardModel->updateCard($data);
    }
}
?>