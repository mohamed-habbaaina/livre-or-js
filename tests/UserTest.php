<?php

require_once './class/User.php';
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
        $this->assertTrue(is_array($this->user->check_DB("iron")));
    }

    public function testRegister()
    {
        $this->assertTrue(is_array($this->user->check_DB("test")));
        $this->user->register("test@test.com", "test", "test");
        $this->assertEquals(201, http_response_code());
    }

    public function testIsUserInserted(): void
    {
        $this->assertTrue(is_array($this->user->check_DB("test")));
    }

    public function tearDown(): void
    {
        $db = $this->user->getDb();

        $request = $db->prepare("DELETE FROM utilisateurs WHERE login='test'");
        $request->execute();
    }
}