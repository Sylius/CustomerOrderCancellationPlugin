<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>
<h1 align="center">Customer Order Cancellation Plugin</h1>

This plugin allows customers to cancel the placed order before it is processed.

## Installation

1. Require plugin using Composer:
 
    `composer require sylius/customer-order-cancellation-plugin`.

2. Add plugin class to your `AppKernel`:

    ```php
    $bundles = [
       new \Sylius\CustomerOrderCancellationPlugin\SyliusCustomerOrderCancellationPlugin(),
    ];
    ```

3. Import routing:

    ```yaml
    sylius_customer_order_cancellation_plugin:
        resource: "@SyliusCustomerOrderCancellationPlugin/Resources/config/routing.yml"
        prefix: /{_locale}
        requirements:
            _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
    ```

## Usage example

![Usage example](docs/screenshot.png)

