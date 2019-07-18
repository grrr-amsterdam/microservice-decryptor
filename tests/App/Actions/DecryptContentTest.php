<?php

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;
use App\Actions\DecryptContent;

class DecryptContentTest extends TestCase
{
    public function testDecrypt(): void
    {
        $decryptContent = new DecryptContent();
        $content = 'Hello world, man!';
        $key = Key::createNewRandomKey();
        $encrypted = Crypto::encrypt($content, $key);
        $this->assertEquals(
            $content,
            $decryptContent->execute($key->saveToAsciiSafeString(), $encrypted)
        );
    }
}
