<?php
    class User {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function register($data) {
            $this->db->query('INSERT INTO users (username, email, password) VALUES(:username, :email, :password)');
    
            //Bind values
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
    
            //Execute function
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    
        public function login($username, $password) {
            $this->db->query('SELECT * FROM users WHERE username = :username');
    
            //Bind value
            $this->db->bind(':username', $username);
    
            $row = $this->db->single();
    
            $hashedPassword = $row->password;
    
            if (password_verify($password, $hashedPassword)) {
                return $row;
            } else {
                return false;
            }
        }

        //to delete from the pwdreset at the db
        public function recoverPassword($data) {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            
            //Bind Value
            $this->db->bind(':email', $data['email']);

            $row = $this->db->single();
            return $row;
        }

        //insert hashedtoken and the selector at the db
        public function sendToken($data, $code) {
            $this->db->query('UPDATE users SET code = :code WHERE email = :email');

             //Bind Value
             $this->db->bind(':email', $data['email']);
             $this->db->bind(':code', $code);

              //Execute the statement
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

       public function codeReset($data) {
           //Prepared statement
           $this->db->query('SELECT * FROM users WHERE code = :code');

            //Bind Value
            $this->db->bind(':code', $data['code']);

            $row = $this->db->single();
            return $row;
       }


       public function updatePassword($code, $userSession, $hashedPassword) {
        $this->db->query('UPDATE users SET code = :code, password = :password WHERE email = :email');

        $this->db->bind(':code', $code);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':email', $userSession);
        
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
       }



        //Find user by email. Email is passed in by the Controller.
        public function findUserByEmail($email) {
            //Prepared statement
            $this->db->query('SELECT * FROM users WHERE email = :email');

            //Email param will be binded with the email variable
            $this->db->bind(':email', $email);

            //Check if email is already registered
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
       
    }