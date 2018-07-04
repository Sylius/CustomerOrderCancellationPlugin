<?php

declare(strict_types=1);

namespace Tests\Sylius\CustomerOrderCancellationPlugin\Behat\Context\Shop;

use Behat\Behat\Context\Context;
use Tests\Sylius\CustomerOrderCancellationPlugin\Behat\Page\Shop\Account\Order\IndexPageInterface;
use Webmozart\Assert\Assert;

final class AccountContext implements Context
{
    /** @var IndexPageInterface */
    private $orderIndexPage;

    public function __construct(IndexPageInterface $orderIndexPage)
    {
        $this->orderIndexPage = $orderIndexPage;
    }

    /**
     * @When I cancel the order :orderNumber
     */
    public function iCancelTheOrder(string $orderNumber): void
    {
        $this->orderIndexPage->clickCancelButtonNextToTheOrder($orderNumber);
    }

    /**
     * @Then the order :orderNumber should be cancelled
     */
    public function orderShouldBeCancelled(string $orderNumber): void
    {
        Assert::true($this->orderIndexPage->isOrderCancelled($orderNumber));
    }

    /**
     * @Then it should not be possible to cancel the order :orderNumber
     */
    public function itShouldNotBePossibleToCancelTheOrder(string $orderNumber): void
    {
        Assert::false($this->orderIndexPage->isCancelButtonVisibleForOrderWithNumber($orderNumber));
    }
}
