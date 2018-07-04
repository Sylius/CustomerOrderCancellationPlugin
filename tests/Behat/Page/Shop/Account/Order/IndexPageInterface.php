<?php

declare(strict_types=1);

namespace Tests\Sylius\CustomerOrderCancellationPlugin\Behat\Page\Shop\Account\Order;

interface IndexPageInterface
{
    public function isCancelButtonVisibleForOrderWithNumber(string $number): bool;

    public function clickCancelButtonNextToTheOrder(string $number): void;

    public function isOrderCancelled(string $number): bool;
}
