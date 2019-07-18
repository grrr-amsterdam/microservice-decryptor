<?php

use App\Actions\VerifyPassword;

class VerifyPasswordTest extends TestCase
{
    public function testVerify(): void
    {
        $verifyPassword = new VerifyPassword();
        $salt = 'salty_dog';
        $passwordPlain = 'bunnywabbit';
        $passwordHashed = password_hash($passwordPlain . $salt, PASSWORD_BCRYPT);
        $this->assertTrue($verifyPassword->execute($passwordPlain, $passwordHashed, $salt));
        $this->assertFalse($verifyPassword->execute('wrong!', $passwordHashed, $salt));
    }
}
