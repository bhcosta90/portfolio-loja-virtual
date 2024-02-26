<?php


use Domain\Enums\OrderPaymentTypeEnum;
use Domain\Exceptions\OrderPaymentCreditCardNotFound;
use Domain\OrderPayment;
use Domain\ValueObjects\CreditCard;
use Domain\ValueObjects\Exceptions\CreditCardException;

use function PHPUnit\Framework\assertEquals;

describe('OrderPaymentTest Feature Test', function () {
    test("create a billing payment", function () {
        $domain = new OrderPayment(
            type: OrderPaymentTypeEnum::BILLING,
            value: 100,
            creditCard: null,
        );

        expect("billing")->toBe($domain->getType()->value)
            ->and(100)->toBe($domain->getValue())
            ->and(null)->toBe($domain->getCreditCard());
    });

    test("create a pix payment", function () {
        $domain = new OrderPayment(
            type: OrderPaymentTypeEnum::PIX,
            value: 100,
            creditCard: null,
        );

        expect("pix")->toBe($domain->getType()->value)
            ->and(100)->toBe($domain->getValue())
            ->and(null)->toBe($domain->getCreditCard());
    });

    test("create a credit card payment and encrypt decrypt data", function () {
        expect(fn () => new OrderPayment(
            type: OrderPaymentTypeEnum::CREDIT_CARD,
            value: 100,
            creditCard: null,
        ))->toThrow(new OrderPaymentCreditCardNotFound())
            ->and(fn () => new OrderPayment(
                type: OrderPaymentTypeEnum::CREDIT_CARD,
                value: 100,
                creditCard: new CreditCard(
                    name: 'testing',
                    number: '123456',
                    month: '01',
                    year: '2000',
                    cvc: '123'
                ),
            ))->toThrow(
                new CreditCardException("The month and year cannot be smaller than the current month and year")
            );

        $domain = new OrderPayment(
            type: OrderPaymentTypeEnum::CREDIT_CARD,
            value: 100,
            creditCard: new CreditCard(
                name: 'testing',
                number: '123456',
                month: date('m'),
                year: date('Y'),
                cvc: '123'
            ),
        );

        expect("credit-card")->toBe($domain->getType()->value)
            ->and(100)->toBe($domain->getValue())
            ->and($domain->getCreditCard())->not->toBeEmpty();

        #----------------------------------------------------------#

        assertEquals([
            "name" => "testing",
            "number" => "123456",
            "month" => "02",
            "year" => "2024",
            "cvc" => "123",
        ], CreditCard::decrypt($domain->getCreditCard()));
    });
});
