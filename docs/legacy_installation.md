### Legacy installation (without Symfony Flex)

1. Require plugin using Composer:
 
    ```bash
    composer require sylius/customer-order-cancellation-plugin
    ```

2. Add plugin class to your `AppKernel`:

    ```php
    $bundles = [
       new \Sylius\CustomerOrderCancellationPlugin\SyliusCustomerOrderCancellationPlugin(),
    ];
    ```

3. Import routing to `app/config/routing.yml`:

    ```yaml
    sylius_customer_order_cancellation_plugin:
        resource: "@SyliusCustomerOrderCancellationPlugin/Resources/config/routing.yml"
        prefix: /{_locale}
        requirements:
            _locale: ^[a-z]{2}(?:_[A-Z]{2})?$
    ```
