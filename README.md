<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">Customer Order Cancellation Plugin</h1>

<p align="center">This plugin allows customers to cancel the placed order before it is processed.</p>

![Screenshot showing the customer's orders page with cancel buttons](docs/screenshot.png)

## Business Value

So far, once a Customer changed their mind about already placed Order, it was up to the Administrator to cancel the order.
However, we have asked ourselves a question - why can't Customer cancel the order when it is yet to be paid? Here comes
Customer Order Cancellation Plugin that allows canceling the unpaid order straight from the order history view.

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
## Extension points

Customer Order Cancellation plugin uses `Order` entity derived from SyliusCoreBundle as well as its already defined states.

Default plugin implementation assumes that an Order can be canceled by a Customer when its payment state is 
`awaiting_payment` and shipment state equals `ready`. This conditions can be easily changed by creating a custom
implementation of `CustomerOrderCancellationCheckerInterface` or decorating the existing one.
