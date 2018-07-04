<?php

declare(strict_types=1);

namespace Sylius\CustomerOrderCancellationPlugin\Checker;

use Sylius\Component\Core\Model\OrderInterface;

interface CustomerOrderCancellationCheckerInterface
{
    public function canBeCancelled(OrderInterface $order): bool;
}
