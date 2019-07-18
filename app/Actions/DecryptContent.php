<?php
declare(strict_types=1);

namespace App\Actions;

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

final class DecryptContent
{

    public function execute(string $key, string $hashedContent): string
    {
        return Crypto::decrypt(
            $hashedContent,
            Key::loadFromAsciiSafeString($key)
        );
    }

}
