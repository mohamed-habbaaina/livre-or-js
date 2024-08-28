<?php

class User
{
    public $login;
    public $email;
    private $password;
    private $repass;
    private $data;
    private $comment;
    private $id;

    // La DB.
    private string $servername = "localhost";
    private string $username_b = "user";
    private string $password_b = "password";
    private string $database = "mydb";

    protected $db;

    // la connexion à la DB.

    public function __construct()
    {
        try {
            $this->db = new PDO(
                "pgsql:host=$this->servername;dbname=$this->database",
                "$this->username_b",
                "$this->password_b"
            );
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function isValid(string $element): string
    {
        return htmlspecialchars(strip_tags(trim($element)));
    }

    /**
     * @return array[0]["$data"]
     */
    public function check_DB($login)
    {
        $data = $this->db->prepare(
            "SELECT * FROM utilisateurs WHERE login=:login"
        );
        $data->execute([":login" => $login]);
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @return int 201 when success
     */
    public function register($email, $login, $password)
    {
        if (empty($this->check_DB($login))):
            $request = $this->db->prepare(
                "INSERT INTO utilisateurs (email, login, password) VALUES (:email, :login, :password)"
            );
            $request->execute([
                ":email" => $email,
                ":login" => $login,
                ":password" => $password,
            ]);
            return header("http/1.1 201 created");
        endif;
        header("http/1.1 400 Bad Request");
    }

    /**
     * @return true,false
     */
    public function isConnected()
    {
        if (isset($_SESSION["login"])):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * @return  true,false
     */

    public function connection($login, $password)
    {
        $data = $this->check_DB($login);

        if (count($data) > 0):
            $password_db = $data[0]["password"];

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
    public function getId($login)
    {
        $data = $this->check_DB($login);

        if (count($data) > 0):
            return $data[0]["id"];
        endif;
    }

    /**
     * @return $_POST['comment']
     */
    public function securComment(string $comment): string
    {
        $this->comment = addslashes(htmlspecialchars($comment));
        return $this->comment;
    }

    /**
     * @return true,false
     */
    public function validComment(string $comment): bool
    {
        if (strlen($comment) > 7):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * inser comment in DB
     */
    public function inserComment($comment, $id): void
    {
        $requestComment = $this->db->prepare(
            "INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (:comment, :id, NOW())"        );
        $result = $requestComment->execute([
            ':comment' => $comment,
            ':id' => $id
        ]);

        if ($result) {
            header("http/1.1 201 created");
        } else {
            header("http/1.1 400 Bad Request");
        }

    }

    public function deconnect()
    {
        $_SESSION = []; //Ecraser le tableau de session
        session_unset(); //Detruit toutes les variables de la session en cours
        session_destroy(); //Destruit la session en cours
    }

    /**
     **  Retrieve the data from the comments table and the login that posted the comment
     //? utilisateurs INNER JOIN `commentaires` ON utilisateurs.id = commentaires.id_utilisateur
     */
    /**
     * Retrieve all comments from the database
     *
     * @return array
     */
    public function livrOr(): array
    {
        $queryAllComment = $this->db->prepare(
            "SELECT login, commentaire, date FROM utilisateurs INNER JOIN commentaires ON utilisateurs.id = commentaires.id_utilisateur ORDER BY date DESC"
        );
        $queryAllComment->execute();

        return $queryAllComment->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update user profile
     *
     * @param string $login
     * @param string $password
     * @param string $lastLogin
     * @return void
     */
    public function update($login, $password, $lastLogin)
    {
        $requ_updt = $this->db->prepare(
            "UPDATE utilisateurs SET login=:login, password=:password WHERE login=:lastLogin"
        );
        $requ_updt->execute([
            ":login" => $login,
            ":password" => $password,
            ":lastLogin" => $lastLogin
        ]);
    }

    public function getDb()
    {
        return $this->db;
    }
}
