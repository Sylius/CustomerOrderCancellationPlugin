<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Sylius\CustomerOrderCancellationPlugin\Checker;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderPaymentStates;
use Sylius\Component\Core\OrderShippingStates;
use Sylius\CustomerOrderCancellationPlugin\Checker\CustomerOrderCancellationCheckerInterface;

final class CustomerOrderCancellationCheckerSpec extends ObjectBehavior
{

    function it_implements_customer_order_cancellation_checker_interface(): void
    {
        $this->shouldImplement(CustomerOrderCancellationCheckerInterface::class);
    }

    function it_returns_true_when_order_is_unpaid_and_unshipped(OrderInterface $order): void
    {
        $order->getPaymentState()->willReturn(OrderPaymentStates::STATE_AWAITING_PAYMENT);
        $order->getShippingState()->willReturn(OrderShippingStates::STATE_READY);

        $this->canBeCancelled($order)->shouldReturn(true);
    }

    function it_returns_false_when_order_is_paid_and_unshipped(OrderInterface $order): void
    {
        $order->getPaymentState()->willReturn(OrderPaymentStates::STATE_PAID);
        $order->getShippingState()->willReturn(OrderShippingStates::STATE_READY);

        $this->canBeCancelled($order)->shouldReturn(false);
    }

    function it_returns_false_when_order_is_unpaid_and_shipped(OrderInterface $order): void
    {
        $order->getPaymentState()->willReturn(OrderPaymentStates::STATE_AWAITING_PAYMENT);
        $order->getShippingState()->willReturn(OrderShippingStates::STATE_SHIPPED);

        $this->canBeCancelled($order)->shouldReturn(false);
    }

    function it_returns_false_when_order_is_paid_and_shipped(OrderInterface $order): void
    {
        $order->getPaymentState()->willReturn(OrderPaymentStates::STATE_PAID);
        $order->getShippingState()->willReturn(OrderShippingStates::STATE_SHIPPED);

        $this->canBeCancelled($order)->shouldReturn(false);
    }
}
