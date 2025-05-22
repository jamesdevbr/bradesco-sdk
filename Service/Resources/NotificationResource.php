<?php

namespace JamesDevBR\BradescoSDK\Services\Resources;

use JamesDevBR\BradescoSDK\Services\Traits\ErrorTrait;
use Exception;

/**
 * Class NotificationResource
 * Feature for encryption and decryption of notifications.
 */
class NotificationResource
{
    use ErrorTrait;

    /**
     * Decrypts the received data.
     *
     * @param array $input
     * @param string $secret
     * @return mixed|false
     */
    public function decrypt($input, $secret)
    {
        if (empty($input['pedido']) || empty($secret)) {

            $this->setError('Invalid decryption key or return data from Bradesco.');

            return false;
        }

        $strToDecrypt = $input['pedido']['dados'];

        $secret .= $input['pedido']['numero'];

        try {
            $salt = 'ComercioBradesco';
            $iterations = 65536; // Fixed iterations
            $dkLen = 256 / 8; // Key length in bytes (256 bits)

            // Initialization Vector (IV) set as 16 bytes of zeros
            $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

            // Generating the key using PBKDF2WithHmacSHA256
            $key = hash_pbkdf2('sha256', $secret, $salt, $iterations, $dkLen, true);

            // Initializing the Cipher for AES/CBC/PKCS5Padding
            $cipher = 'AES-256-CBC';

            $result = openssl_decrypt(base64_decode($strToDecrypt), $cipher, $key, OPENSSL_RAW_DATA, $iv);

            return json_decode($result);

        } catch (Exception $e) {
            $this->setError('An error occurred while decrypting.', $e);

            return false;
        }
    }

    /**
     * Encrypts the provided string.
     *
     * @param string $strToEncrypt
     * @param string $secret
     * @return string|false
     */
    public function encrypt($strToEncrypt, $secret)
    {
        try {
            $salt = 'ComercioBradesco';
            $iterations = 65536; // Fixed iterations
            $dkLen = 256 / 8;     // Key length in bytes (256 bits)

            // Initialization Vector (IV) set as 16 bytes of zeros
            $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

            // Generating the key using PBKDF2WithHmacSHA256
            $key = hash_pbkdf2('sha256', $secret, $salt, $iterations, $dkLen, true);

            // Initializing the Cipher for AES/CBC/PKCS5Padding
            $cipher = 'AES-256-CBC';
            $encrypted = openssl_encrypt($strToEncrypt, $cipher, $key, OPENSSL_RAW_DATA, $iv);

            // Returns the encrypted result in base64
            return base64_encode($encrypted);

        } catch (Exception $e) {
            $this->setError('An error occurred while encrypting', $e);

            return false;
        }

    }
}
