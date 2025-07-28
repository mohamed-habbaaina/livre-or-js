<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class User
{
    public $login;
    public $email;
    private $password;
    private $repass;
    private $data;
    private $comment;
    private $id;

    // MongoDB configuration
    private string $mongoUri = "mongodb://mongodb:27017";
    private string $database = "livre_or";

    protected $client;
    protected $db;
    protected $utilisateursCollection;
    protected $commentairesCollection;

    // MongoDB connection

    public function __construct()
    {
        try {
            $this->client = new Client($this->mongoUri);
            $this->db = $this->client->selectDatabase($this->database);
            $this->utilisateursCollection = $this->db->selectCollection('utilisateurs');
            $this->commentairesCollection = $this->db->selectCollection('commentaires');
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function isValid(string $element): string
    {
        return htmlspecialchars(strip_tags(trim($element)));
    }

    /**
     * @return array|null
     */
    public function check_DB($login)
    {
        $user = $this->utilisateursCollection->findOne(['login' => $login]);
        return $user ? $user->toArray() : null;
    }

    /**
     *
     * @return int 201 when success
     */
    public function register($email, $login, $password)
    {
        $existingUser = $this->check_DB($login);
        
        if (empty($existingUser)) {
            try {
                $result = $this->utilisateursCollection->insertOne([
                    'email' => $email,
                    'login' => $login,
                    'password' => $password,
                ]);
                
                if ($result->getInsertedCount() > 0) {
                    return header("http/1.1 201 created");
                }
            } catch (Exception $e) {
                error_log("Erreur d'insertion: " . $e->getMessage());
            }
        }
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

    public function connection(string $login, string $password)
    {
        $userData = $this->check_DB($login);

        if (!empty($userData)) {
            $password_db = $userData["password"];

            if (password_verify($password, $password_db)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @return string|null
     */
    public function getId($login)
    {
        $userData = $this->check_DB($login);

        if (!empty($userData)) {
            return (string) $userData["_id"];
        }
        return null;
    }

    /**
     * @return string
     */
    public function securComment(string $comment): string
    {
        $this->comment = addslashes(htmlspecialchars($comment));
        return $this->comment;
    }

    /**
     * @return bool
     */
    public function validComment(string $comment): bool
    {
        if (strlen($comment) > 7) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Insert comment in MongoDB
     */
    public function inserComment($comment, $id): void
    {
        try {
            $this->commentairesCollection->insertOne([
                'commentaire' => $comment,
                'id_utilisateur' => new ObjectId($id),
                'date' => new UTCDateTime()
            ]);
        } catch (Exception $e) {
            error_log("Erreur lors de l'insertion du commentaire: " . $e->getMessage());
        }
    }

    public function deconnect()
    {
        $_SESSION = []; //Ecraser le tableau de session
        session_unset(); //Detruit toutes les variables de la session en cours
        session_destroy(); //Destruit la session en cours
    }

    /**
     * Retrieve all comments from MongoDB with user login using aggregation
     *
     * @return array
     */
    public function livrOr(): array
    {
        try {
            $pipeline = [
                [
                    '$lookup' => [
                        'from' => 'utilisateurs',
                        'localField' => 'id_utilisateur',
                        'foreignField' => '_id',
                        'as' => 'user'
                    ]
                ],
                [
                    '$unwind' => '$user'
                ],
                [
                    '$project' => [
                        'login' => '$user.login',
                        'commentaire' => 1,
                        'date' => 1
                    ]
                ],
                [
                    '$sort' => ['date' => -1]
                ]
            ];

            $cursor = $this->commentairesCollection->aggregate($pipeline);
            $results = [];

            foreach ($cursor as $document) {
                $results[] = [
                    'login' => $document['login'],
                    'commentaire' => $document['commentaire'],
                    'date' => $document['date']->toDateTime()->format('Y-m-d H:i:s')
                ];
            }

            return $results;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des commentaires: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Update user profile in MongoDB
     *
     * @param string $login
     * @param string $password
     * @param string $lastLogin
     * @return void
     */
    public function update($login, $password, $lastLogin)
    {
        try {
            $this->utilisateursCollection->updateOne(
                ['login' => $lastLogin],
                [
                    '$set' => [
                        'login' => $login,
                        'password' => $password
                    ]
                ]
            );
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour: " . $e->getMessage());
        }
    }

    public function getDb()
    {
        return $this->db;
    }
}
