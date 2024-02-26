<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('play', function () {
    function encryptData($data, $key, $iv)
    {
        $cipherMethod = 'aes-256-cbc';
        $options = 0;

        $encryptedData = openssl_encrypt($data, $cipherMethod, $key, $options, $iv);

        // Combine the IV and encrypted data for storage or transmission
        $encryptedDataWithIV = base64_encode($iv . $encryptedData);

        return $encryptedDataWithIV;
    }

    function decryptData($encryptedDataWithIV, $key)
    {
        $cipherMethod = 'aes-256-cbc';
        $options = 0;

        // Extract the IV and encrypted data
        $data = base64_decode($encryptedDataWithIV);
        $ivSize = openssl_cipher_iv_length($cipherMethod);
        $iv = substr($data, 0, $ivSize);
        $encryptedData = substr($data, $ivSize);

        // Decrypt the data
        $decryptedData = openssl_decrypt($encryptedData, $cipherMethod, $key, $options, $iv);

        return $decryptedData;
    }

// Example usage:

    $key = 'your_secret_key_here'; // Replace with your actual secret key

// Generate a random IV (Initialization Vector)
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

// Data to be encrypted
    $dataToEncrypt = 'Hello, world!';

// Encrypt the data
    $encryptedData = encryptData($dataToEncrypt, $key, $iv);
    echo 'Encrypted Data: ' . $encryptedData . PHP_EOL;

// Decrypt the data
    $decryptedData = decryptData($encryptedData, $key);
    echo 'Decrypted Data: ' . $decryptedData . PHP_EOL;
});
