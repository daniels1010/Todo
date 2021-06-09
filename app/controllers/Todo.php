<?php
class Todo extends Controller{
    public function  __construct() {
        $this->cardModel = $this->model('Card');
    }

    public function index() {
        $cards = $this->cardModel->getCards();
        $cardAge = [];
        foreach ($cards as $card) {
            $cardAge[$card->card_id] = $this->cardModel->time_elapsed_string($card->created_at);
        }
        
        $data = [
            'cards' => $cards,
            'cardAge' => $cardAge,
        ];
        $this->view('todo/index', $data);
    }

    public function create() {
        
        $data = [
            'title' => '',
            'description' => '',
            'titleError' => '',
            'descriptionError' => '',
        ];

        if($_SERVER['REQUEST_METHOD']=='POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'titleError' => '',
                'descriptionError' => '',
            ];

            if (empty($data['title'])) {
                $data['titleError'] = 'Lūdzu ievadiet virsrakstu';
            } else {
                if ($this->cardModel->saveCard($data)) {
                    header('location:'. URLROOT . '/todo/index');
                } else {
                    die('kaut kas nogāja greizi, mēģiniet vēlreiz.');
                }
            }
        }
        
        $this->view('todo/create', $data);
    }


    public function edit($id) {
        $post = $this->cardModel->findCardById($id);
        $data = [
            'post' => $post,
            'titleError' => '',
            'descriptionError' => '',
        ];

        if($_SERVER['REQUEST_METHOD']=='POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'post' => $post,
                'id' => $id,
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'titleError' => '',
                'descriptionError' => '',
            ];

            if (empty($data['title'])) {
                $data['titleError'] = 'Virsraksta lauks nedrīkst būt tukšs';
            } else {
                if ($this->cardModel->updateCard($data)) {
                    header('location:'. URLROOT . '/todo/index');
                } else {
                    die('kaut kas nogāja greizi, mēģiniet vēlreiz.');
                }
            }
        }
        
        $this->view('todo/edit', $data);
    }
    
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if ($this->cardModel->deleteCard($id)) {
                header('location:'. URLROOT . '/todo/index');
            } else {
                die('Nevarēja izdzēst pierakstu, lūdzu mēģiniet vēlreiz');
            }
        }
    }

    public function toggleCheckbox($id) {
        $card = $this->cardModel->findCardById($id);
        $data = [
            'id' => $card->card_id,
            'title' => $card->title,
            'description' => $card->description,
            'isChecked' => !$card->isChecked
        ];  
        $this->cardModel->updateCard($data);
    }
}
?>