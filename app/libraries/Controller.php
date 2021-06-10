<?php 

    // Izveido csrf atslēgu
    session_start();

    if (empty($_SESSION['key'])) {
        $_SESSION['key'] = bin2hex(random_bytes(32));
    } 

    class Controller {
        public function model($model) {
            require_once '../app/models/'. $model . '.php';
            return new $model();
        }


        public function view($view, $data = []) {
            if (file_exists('../app/views/'. $view . '.php')) {
                require_once '../app/views/'. $view . '.php';
            } else {
                die ('View does not exist.');
            }
        }

        // Salīdzina CSRF atslēgas
        public function validateCSRF() {
            if (!empty($_POST['csrf'])) {
                if (!hash_equals($_SESSION['key'], $_POST['csrf'])) {
                    die('CSRF atslēgas nesakrīt!');
                }
            }
        }

        public function postMethod() {
            return $_SERVER['REQUEST_METHOD']=='POST';
        }

        public function sanitizeInput($input) {
            $input = stripslashes($input);
            $input = filter_input_array($input, FILTER_SANITIZE_STRING);
            $input['title'] = trim($input['title']);
            $input['description'] = trim($input['description']);
            return $input;
        }

        public function returnToTodoIndex() {
            return header('location:'. URLROOT . '/todo/index');
        }

        // Validē jaunos datus, ja kaut kas neatbalst nosacījumiem, atgriež brīdinājumu
        public function findInputErrors($data) {   
            if (empty($data['title'])) {
                $data['titleError'] = 'Lūdzu ievadiet virsrakstu';
            } elseif (strlen($data['title'])>255){
                $data['titleError'] = 'Virsraksta lauks nedrīkst pārsniegt 255 simbolus';
            } elseif (strlen($data['description'])>255){
                $data['descriptionError'] = 'Apraksta lauks nedrīkst pārsniegt 255 simbolus';
            }

            return $data;
        }

        public function checkIfInputError($data) {
            return $data['titleError'] == '' and $data['descriptionError'] == '';
        }

    }

?>