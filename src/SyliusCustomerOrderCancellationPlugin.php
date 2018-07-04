<?php

declare(strict_types=1);

namespace Sylius\CustomerOrderCancellationPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusCustomerOrderCancellationPlugin extends Bundle
{
    use SyliusPluginTrait;
}
