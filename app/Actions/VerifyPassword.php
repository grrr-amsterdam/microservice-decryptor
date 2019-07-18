<?php
declare(strict_types=1);

namespace App\Actions;

final class VerifyPassword
{

    public function execute(string $plainPass, string $hashedPass, string $salt): bool
    {
        return password_verify($plainPass . $salt, $hashedPass);
    }

}
