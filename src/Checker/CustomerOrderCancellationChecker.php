<?php

declare(strict_types=1);

namespace Sylius\CustomerOrderCancellationPlugin\Checker;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderPaymentStates;
use Sylius\Component\Core\OrderShippingStates;

final class CustomerOrderCancellationChecker implements CustomerOrderCancellationCheckerInterface
{
    public function canBeCancelled(OrderInterface $order): bool
    {
        return
            OrderPaymentStates::STATE_AWAITING_PAYMENT === $order->getPaymentState() &&
            OrderShippingStates::STATE_READY === $order->getShippingState()
        ;
    }
}
