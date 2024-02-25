<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

use JsonException;

use function compact;
use function getenv;
use function json_decode;
use function json_encode;
use function openssl_decrypt;

class CreditCard
{
    protected string $hash;

    /**
     * @throws JsonException
     */
    public function __construct(
        protected string $name,
        protected string $number,
        protected string $month,
        protected string $year,
        protected string $cvc,
    ) {
        $this->encrypt(
            compact(
                $this->name,
                $this->number,
                $this->month,
                $this->year,
                $this->cvc
            )
        );
    }

    /**
     * @throws JsonException
     */
    protected function encrypt(array $data): string
    {
        $key = $this->getKey();

        $cipher = 'aes-256-cbc';
        $options = 0;

        return openssl_encrypt(json_encode($data, JSON_THROW_ON_ERROR), $cipher, $key, $options);
    }

    protected function getKey(): string
    {
        return getenv('CREDIT_CARD_KEY') ?: 'CREDIT_CARD_KEY';
    }

    /**
     * @throws JsonException
     */
    protected static function decrypt($encryptedData): array
    {
        $cipher = "aes-256-cbc";
        $options = 0;

        return json_decode(
            openssl_decrypt($encryptedData, $cipher, self::getKey(), $options),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
