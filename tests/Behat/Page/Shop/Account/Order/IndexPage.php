<?php

declare(strict_types=1);

namespace Tests\Sylius\CustomerOrderCancellationPlugin\Behat\Page\Shop\Account\Order;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Webmozart\Assert\Assert;

final class IndexPage extends SymfonyPage implements IndexPageInterface
{
    public function isCancelButtonVisibleForOrderWithNumber(string $number): bool
    {
        $orderData = $this->getOrderData($number);

        $cancelButton = $orderData->find('css', 'td button:contains("Cancel")');

        return null !== $cancelButton;
    }

    public function clickCancelButtonNextToTheOrder(string $number): void
    {
        $orderData = $this->getOrderData($number);

        $cancelButton = $orderData->find('css', 'td button:contains("Cancel")');

        Assert::notNull($cancelButton, sprintf('There is no cancel button next to order %s', $number));

        $cancelButton->click();
    }

    public function isOrderCancelled(string $number): bool
    {
        $orderData = $this->getOrderData($number);

        return $orderData->find('css', 'td:nth-child(5)')->getText() === 'Cancelled';
    }

    private function getOrderData(string $orderNumber): NodeElement
    {
        $orderData = $this->getSession()->getPage()->find('css', sprintf('tr:contains("%s")', $orderNumber));

        Assert::notNull($orderData);

        return $orderData;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
       return 'sylius_shop_account_order_index';
    }
}
