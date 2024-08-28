<?php

require_once './class/User.php';
class CommentTest extends \PHPUnit\Framework\TestCase
{
    protected User $user;
    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testSecureComment(): void
    {
        $this->assertEquals("ça test&#039;!", $this->user->securComment("ça test'!"));
    }

    public function testLengthComment(): void
    {
        $this->assertTrue(($this->user->validComment("Salut, comment ça va ?")));
    }

    public function testInsertComment(): void
    {
        $this->user->inserComment("Salut, comment ça va ?", 1);
        $this->assertEquals(201, http_response_code());
    }

    public function testGetAllComment(): void
    {
        $this->assertTrue(is_array($this->user->livrOr()));
    }
}