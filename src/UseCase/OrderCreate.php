<?php

declare(strict_types=1);

namespace UseCase;

use Contracts\DatabaseInterface;
use Contracts\EventManagerInterface;
use Domain\Enums\OrderPaymentTypeEnum;
use Domain\Events\OrderCreateEvent;
use Domain\Exceptions\OrderNoItemException;
use Domain\Exceptions\OrderPaymentCreditCardNotFound;
use Domain\Order;
use Domain\OrderPayment;
use Domain\OrderProduct;
use Domain\Repository\OrderRepositoryInterface;
use Domain\ValueObjects\CreditCard;
use Domain\ValueObjects\Exceptions\CreditCardException;
use UseCase\Exceptions\OrderCreateException;

use function array_map;

class OrderCreate
{
    protected array $products = [];
    protected array $payments = [];

    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected DatabaseInterface $database,
        protected EventManagerInterface $eventManager,
    ) {
    }

    /**
     * @throws OrderNoItemException
     * @throws OrderCreateException
     */
    public function execute(string $customer, string $address, int $shipping): DTO\OrderOutput
    {
        $order = new Order(
            customer: $customer,
            address: $address,
            shipping: $shipping
        );

        array_map(fn (OrderProduct $product) => $order->addProduct($product), $this->products);
        array_map(fn (OrderPayment $payment) => $order->addPayment($payment), $this->payments);

        if (!count($this->products) || !count($this->payments)) {
            throw new OrderCreateException("Products or payments not informed");
        }

        return $this->database->transaction(function () use ($order) {
            $orderDb = $this->orderRepository->create($order);
            $this->eventManager->dispatch(new OrderCreateEvent($orderDb));
            return DTO\OrderOutput::make($orderDb);
        });
    }

    public function addProduct(string $id, string $name, int $value, int $quantity): self
    {
        $this->products[] = new OrderProduct(id: $id, name: $name, value: $value, quantity: $quantity);
        return $this;
    }

    /**
     * @throws CreditCardException
     * @throws OrderPaymentCreditCardNotFound
     */
    public function addPayment(
        string $type,
        ?int $value = null,
        ?string $creditCardName = null,
        ?string $creditCardNumber = null,
        ?string $creditCardMonth = null,
        ?string $creditCardYear = null,
        ?string $creditCardCvc = null
    ): self {
        $this->payments[] = new OrderPayment(
            type: OrderPaymentTypeEnum::from($type),
            value: $value,
            creditCard: $creditCardName && $creditCardNumber && $creditCardMonth && $creditCardYear && $creditCardCvc
                ? new CreditCard(
                    name: $creditCardName,
                    number: $creditCardNumber,
                    month: $creditCardMonth,
                    year: $creditCardYear,
                    cvc: $creditCardCvc
                ) : null,
        );
        return $this;
    }
}
