<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use JsonException;

use function compact;
use function json_encode;

class CreditCard
{
    public string $hash;

    public function __construct(
        protected string $name,
        protected string $number,
        protected string $month,
        protected string $year,
        protected string $cvc,
    ) {
        $this->encryptData(compact(
            $this->name,
            $this->number,
            $this->month,
            $this->year,
            $this->cvc
        ));
    }

    /**
     * @throws JsonException
     */
    protected function encryptData(array $data): string
    {
        $key = 'your_secret_key'; // Use a secure key

        $cipher = 'aes-256-cbc';
        $options = 0;

        return openssl_encrypt(json_encode($data, JSON_THROW_ON_ERROR), $cipher, $key, $options);
    }
}
