<?php

    class Card {
        private $db;

        public function __construct() {
            // Piesaista mainīgajam Datubāzi
            $this->db = new Database;
        }

        // Funkcija, kur iegūst visas rindas no tabulas 'cards', jeb iegūst visas kartiņas
        public function getCards() {
            $this->db->query("SELECT * FROM cards");
            $result = $this->db->resultSet();
            return $result;
        }

        // Funkcija, kur izveido jaunu kartiņu
        public function saveCard($data) {
            $this->db->query('INSERT INTO cards (title, description, created_at) VALUES(:title, :description, :created_at)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':created_at', date('Y-m-d H:i:s'));
            return $this->db->execute();
        }

        // Funkcija, kur atjauno kartiņu
        public function updateCard($data) {
            $this->db->query('UPDATE cards SET title = :title, description = :description, isChecked = :isChecked WHERE card_id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':id', $data['card_id']);
            $this->db->bind(':isChecked', $data['isChecked']);
            return $this->db->execute();
        }

        // Funkcija, lai atrastu noteiktu kartiņu pēc tās id
        public function findCardById($id) {
            $this->db->query("SELECT * FROM cards WHERE card_id = :id");
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            return $row;
        }

        // Funkcija, lai izdzēstu kādu noteiktu kartiņu
        public function deleteCard($id) {
            $this->db->query("DELETE FROM cards WHERE card_id = :id");
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }

        // Funkcija, kas izveido tekstu, kurš apzīmē cik sen šī kartiņa tika izveidota
        public function time_elapsed_string($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime($datetime);

            // Iegūst laika starpību, no izveidošanas laika un šī brīža,
            $difference = $now->diff($ago);
        
            // Izrēķina cik nedēļas ir pagājušas
            $difference->w = floor($difference->d / 7);
            $difference->d -= $difference->w * 7;
        
            // laika daudzumu apzīmējumi latviski string->daudzskaitlī singular->vienskaitlī
            $plural = [
                'y' => 'gadiem',
                'm' => 'mēnešiem',
                'w' => 'nedēļām',
                'd' => 'dienām',
                'h' => 'stundām',
                'i' => 'minūtēm',
                's' => 'sekundēm',
            ];

            $singular = [
                'y' => 'gada',
                'm' => 'mēneša',
                'w' => 'nedēļas',
                'd' => 'dienas',
                'h' => 'stundas',
                'i' => 'minūtes',
                's' => 'sekundes',
            ];  
            
            // Izveido jaunu masīvu ar laika vienību struktūru.
            $string = $plural; 

            // pie katras laika vienības, ja tās skaits ir vismaz 1, tad tajā masīva vietā pieliek attiecīgo papildvārdu. 
            // Piemēram: '1' -> '1 sekunde', '4' -> '4 stundas', ja vērtība ir 0, tad vērtību noņem no masīva.
            foreach ($string as $key => &$verb) {
                if ($difference->$key) {
                    $verb = $difference->$key . ' ' . ($difference->$key > 1 ? $plural[$key] : $singular[$key]);
                } else {
                    unset($string[$key]);
                }
            }
            
            // Ja ir precizēts $full argumentos, tad atgriež pilno vērtbu ar visiem laika formātiem kopā
            // Ja nav precizēts $full tad atgriež tikai 1, lielāko laika formātu
            if (!$full) $string = array_slice($string, 0, 1);
            
            // Atgriež iegūto rezultātu, pievienojot sākumā 'pirms', ja tas noticis pagātnē un tagad, ja tas notika tagad (par pagātnē tiek uzskatīta tāds laiks, kas lapas lādēšanas brīdī notika vismaz pirms 1 sekundes :D)
            return $string ? 'pirms ' . implode(', ', $string) : 'tagad';
        }
    }
?>