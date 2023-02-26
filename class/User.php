<?php
class User{

    public $login;
    public $email;
    private $password;
    private $repass;
    private $data;
    private $comment;
    private $id;

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
            echo 'ERROR: ' . $e->getMessage();
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
    public function isConnected(){

        if(isset($_SESSION['login'])):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * @return  true,false
     */

    public function connection($login, $password){

        $data = $this->check_DB($login);

        if(count($data) > 0):

            $password_db = $data[0]['password'];
            
                // verifier le password Haché.
                if (password_verify($password, $password_db)):
                  
                    return true;
                else:
                     return false;
                endif;
        endif;

    }

    /**
     * @return $id
     */
    public function getId($login){

        $data = $this->check_DB($login);

        if(count($data) > 0):

        return $data[0]['id'];

        endif;

    }


    /**
     * @return $_POST['comment']
     */
    public function securComment($comment){

        $this->comment = addslashes(htmlspecialchars($comment));
        return $this->comment;
    }

    /**
     * @return true,false
     */
    public function validComment($comment){
        if(strlen($comment) > 7):

            return true;
        else:
            return false;
        endif;
    }

    /**
     * inser comment in DB
     */
    public function inserComment($comment, $id){

        $requestComment = $this->db->prepare("INSERT INTO `commentaires` (`commentaire`, `id_utilisateur`, `date`) VALUES ('$comment', '$id', NOW())");
        $requestComment->execute();
    }
    

    public function deconnect(){
        
        $_SESSION = array();//Ecraser le tableau de session 
        session_unset(); //Detruit toutes les variables de la session en cours
        session_destroy();//Destruit la session en cours
    }

    /**
     **  Retrieve the data from the comments table and the login that posted the comment
     //? utilisateurs INNER JOIN `commentaires` ON utilisateurs.id = commentaires.id_utilisateur
     */
    public function livrOr(){
        $quryAllComment = $this->db->prepare("SELECT login, commentaire, date FROM utilisateurs INNER JOIN `commentaires` ON utilisateurs.id = commentaires.id_utilisateur ORDER BY date DESC");
        $quryAllComment->execute();

        return $quryAllComment->fetchall(PDO::FETCH_ASSOC);

    }


    // methode pour modifier le profil de user.
    public function update($login, $password, $lastLogin){
        $requ_updt = $this->db->prepare("UPDATE `utilisateurs` SET login=?, password=? WHERE login='$lastLogin';");
        $requ_updt->execute(["$login", "$password"]);
}
}