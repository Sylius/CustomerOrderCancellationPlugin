<?php

declare(strict_types=1);

namespace Sylius\CustomerOrderCancellationPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SyliusCustomerOrderCancellationExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('sylius_grid')) {
            throw new \RuntimeException('SyliusGridBundle must be registered in kernel.');
        }

        $container->prependExtensionConfig('sylius_grid', [
            'templates' => [
                'action' => [
                    'customer_order_cancel' => '@SyliusCustomerOrderCancellationPlugin/Grid/Action/customer_order_cancel.html.twig',
                ],
            ],
            'grids' => [
                'sylius_shop_account_order' => [
                    'actions' => [
                        'item' => [
                            'cancel' => [
                                'type' => 'customer_order_cancel',
                                'label' => 'sylius.ui.cancel',
                                'options' => [
                                    'link' => [
                                        'route' => 'sylius_customer_order_cancellation_plugin_shop_order_cancel',
                                        'parameters' => ['orderNumber' => 'resource.number'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
