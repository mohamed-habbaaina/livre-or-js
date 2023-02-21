<?php
class User{

    public $login;
    public $email;
    private $password;
    private $repass;
    private $data;

    // La DB.
    private $servername = 'localhost';
    private $username_b = 'root';
    private $password_b = '';
    private $database = 'livreor_js';

    private $db;

    // la connexion à la DB.
    public function __construct(){

        try {
            $this->db = new PDO("mysql:host=$this->servername;dbname=$this->database;charset=utf8", "$this->username_b", "$this->password_b");
        }
       catch(PDOException $e){
            echo 'ERREUR: ' . $e->getMessage();
       }
    }

    public function isValid($element){

        $element = htmlspecialchars(strip_tags(trim($element)));
        return $element;

    }

    /**
     * @return array[0]["$data"]
     */
    public function check_DB($login){

        $data = $this->db->prepare("SELECT * FROM `utilisateurs` WHERE login=:login");
        $data->execute([":login" => "$login"]);
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @return INSER INTO DB
     */
    public function register($email, $login, $password){

        if(empty($this->check_DB($login))):

            $request = $this->db->prepare("INSERT INTO `utilisateurs` (`email`, `login`, `password`) VALUE (:email, :login, :password)");
            $request->execute([":email" => "$email", ":login" => "$login", ":password" => "$password"]);

        endif;
    }

    /**
     * @return true,false
     */
    public function isConnected($login){

        if(isset($_SESSION['login'])):
            return true;
        else:
            return false;
        endif;
    }

}