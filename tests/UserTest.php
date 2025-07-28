<?php

require_once './class/User.php';
require_once './vendor/autoload.php';

class UserTest extends \PHPUnit\Framework\TestCase
{
    protected User $user;
    
    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testIsValid()
    {
        $this->assertEquals("test", $this->user->isValid("test"));
    }

    public function testCheck_DB()
    {
        $result = $this->user->check_DB("iron");
        $this->assertTrue(is_array($result) || is_null($result));
    }

    public function testRegister()
    {
        // Test de l'enregistrement d'un utilisateur
        $email = "test@test.com";
        $login = "test_user_" . time(); // Login unique
        $password = password_hash("test123", PASSWORD_DEFAULT);
        
        $this->user->register($email, $login, $password);
        
        // Vérifier que l'utilisateur a été inséré
        $userData = $this->user->check_DB($login);
        $this->assertNotNull($userData);
        $this->assertEquals($login, $userData['login']);
    }

    public function testIsUserInserted(): void
    {
        $testLogin = "test_user_check";
        $email = "testcheck@test.com";
        $password = password_hash("test123", PASSWORD_DEFAULT);
        
        // Insérer un utilisateur de test
        $this->user->register($email, $testLogin, $password);
        
        // Vérifier qu'il existe
        $userData = $this->user->check_DB($testLogin);
        $this->assertNotNull($userData);
    }

    public function tearDown(): void
    {
        $db = $this->user->getDb();
        
        // Nettoyer les utilisateurs de test
        $db->selectCollection('utilisateurs')->deleteMany([
            'login' => ['$regex' => '^test_user_']
        ]);
    }
}