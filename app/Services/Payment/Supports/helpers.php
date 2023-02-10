<?php

use phpseclib\Crypt\RSA;

/*
 *--------------------------------------------------------------------------
 * Helpers
 *--------------------------------------------------------------------------
 *
 * Here is where you can write helpers function for project
 * You need run:  composer dump-autoload to load functions writed
 *
 */

/**
 * Encrypt RSA
 *
 * @param array $rawData
 * @param string $publicKey
 * @return string
 */
if (!function_exists('encryptRsa')) {
    function encryptRsa(array $rawData, $publicKey)
    {
        $rawJson = json_encode($rawData, JSON_UNESCAPED_UNICODE);

        $rsa = new RSA();
        $rsa->loadKey($publicKey);
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $cipher = $rsa->encrypt($rawJson);

        return base64_encode($cipher);
    }
}
