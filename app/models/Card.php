<?php

    class Card {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getCards() {
            $this->db->query("SELECT * FROM cards");
            $result = $this->db->resultSet();
            return $result;
        }

        public function saveCard($data) {
            $this->db->query('INSERT INTO cards (title, description, created_at) VALUES(:title, :description, :created_at)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':created_at', date('Y-m-d H:i:s'));
            return $this->db->execute();
        }

        public function updateCard($data) {
            $this->db->query('UPDATE cards SET title = :title, description = :description, isChecked = :isChecked WHERE card_id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':isChecked', $data['isChecked']);
            return $this->db->execute();
        }

        public function findCardById($id) {
            $this->db->query("SELECT * FROM cards WHERE card_id = :id");
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            return $row;
        }

        public function deleteCard($id) {
            $this->db->query("DELETE FROM cards WHERE card_id = :id");
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }

        public function time_elapsed_string($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);
        
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;
        
            $string = array(
                'y' => 'gadiem',
                'm' => 'mēnešiem',
                'w' => 'nedēļām',
                'd' => 'dienām',
                'h' => 'stundām',
                'i' => 'minūtēm',
                's' => 'sekundēm',
            );

            $singular = array(
                'y' => 'gada',
                'm' => 'mēneša',
                'w' => 'nedēļas',
                'd' => 'dienas',
                'h' => 'stundas',
                'i' => 'minūtes',
                's' => 'sekundes',
            );

            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . ($diff->$k > 1 ? $string[$k] : $singular[$k]);
                } else {
                    unset($string[$k]);
                }
            }
        
            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? 'pirms ' . implode(', ', $string) : 'tagad';
        }
    }

?>