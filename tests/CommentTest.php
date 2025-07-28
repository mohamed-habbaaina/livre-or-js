<?php

require_once './class/User.php';
require_once './vendor/autoload.php';

use MongoDB\BSON\ObjectId;

class CommentTest extends \PHPUnit\Framework\TestCase
{
    protected User $user;
    protected string $testUserId;
    
    public function setUp(): void
    {
        $this->user = new User();
        
        // Créer un utilisateur de test pour les commentaires
        $email = "testcomment@test.com";
        $login = "test_comment_user";
        $password = password_hash("test123", PASSWORD_DEFAULT);
        
        $this->user->register($email, $login, $password);
        $userData = $this->user->check_DB($login);
        $this->testUserId = (string) $userData['_id'];
    }

    public function testSecureComment(): void
    {
        $this->assertEquals("ça test&#039;!", $this->user->securComment("ça test'!"));
    }

    public function testLengthComment(): void
    {
        $this->assertTrue($this->user->validComment("Salut, comment ça va ?"));
        $this->assertFalse($this->user->validComment("court"));
    }

    public function testInsertComment(): void
    {
        $commentText = "Ceci est un commentaire de test très intéressant !";
        $this->user->inserComment($commentText, $this->testUserId);
        
        // Vérifier que le commentaire a été inséré
        $comments = $this->user->livrOr();
        $this->assertNotEmpty($comments);
        
        // Chercher notre commentaire
        $found = false;
        foreach ($comments as $comment) {
            if ($comment['commentaire'] === $commentText) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found);
    }

    public function testGetAllComment(): void
    {
        $comments = $this->user->livrOr();
        $this->assertTrue(is_array($comments));
    }
    
    public function tearDown(): void
    {
        $db = $this->user->getDb();
        
        // Supprimer les commentaires de test
        $db->selectCollection('commentaires')->deleteMany([
            'id_utilisateur' => new ObjectId($this->testUserId)
        ]);
        
        // Supprimer l'utilisateur de test
        $db->selectCollection('utilisateurs')->deleteOne([
            'login' => 'test_comment_user'
        ]);
    }
}