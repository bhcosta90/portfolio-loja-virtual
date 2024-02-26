<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

use Domain\ValueObjects\Exceptions\CreditCardException;
use JsonException;

use function base64_encode;
use function compact;
use function getenv;
use function json_decode;
use function json_encode;
use function openssl_cipher_iv_length;
use function openssl_decrypt;
use function openssl_random_pseudo_bytes;

class CreditCard
{
    protected string $hash;

    /**
     * @throws CreditCardException
     */
    public function __construct(
        protected string $name,
        protected string $number,
        protected string $month,
        protected string $year,
        protected string $cvc,
    ) {
        if ("{$month}{$year}" < date('mY')) {
            throw new CreditCardException("The month and year cannot be smaller than the current month and year");
        }

        $this->hash = $this->encrypt(
            compact(
                'name',
                'number',
                'month',
                'year',
                'cvc'
            )
        );
    }

    /**
     * @throws JsonException
     */
    protected function encrypt(array $data): string
    {
        $cipherMethod = 'aes-256-cbc';
        $options = 0;

        $iv = self::getIv();
        $encryptedData = openssl_encrypt(json_encode($data, JSON_THROW_ON_ERROR), $cipherMethod, self::getKey(), $options, $iv);

        return base64_encode($iv . $encryptedData);
    }

    /**
     * @throws JsonException
     */
    public static function decrypt(string $encryptedData): array
    {
        $cipherMethod = 'aes-256-cbc';
        $options = 0;

        // Extract the IV and encrypted data
        $data = base64_decode($encryptedData);
        $ivSize = openssl_cipher_iv_length($cipherMethod);
        $iv = substr($data, 0, $ivSize);
        $encryptedData = substr($data, $ivSize);

        // Decrypt the data
        $decryptedData = openssl_decrypt($encryptedData, $cipherMethod, self::getKey(), $options, $iv);
        return json_decode($decryptedData, true, 512, JSON_THROW_ON_ERROR);
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    protected static function getKey(): string
    {
        return getenv('CREDIT_CARD_KEY') ?: 'CREDIT_CARD_KEY';
    }

    /**
     * @return string
     */
    protected static function getIv(): string
    {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    }
}
