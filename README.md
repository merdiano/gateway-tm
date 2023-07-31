# Gateway-TM

A simple library that provides integration to local Bank payment processing services in Turkmenistan.

## Introduction

Gateway-TM offers seamless integration with three primary payment services: Rysgal, AltynAsyr, and Senagat. This library facilitates the process of registering payment orders and checking their status. It has been designed to be easily extendable, allowing users to incorporate additional gateway services by extending the AbstractGateway class and implementing their custom class. This ensures a high level of flexibility in integrating new payment service types.
## Requirements

- Laravel 9 or higher
- PHP 8.1 or higher

## Installation & Instructions 
Default installation is via [Composer](https://getcomposer.org/).

```bash
composer require merdan/gateway-tm
```
The package will automatically register itself.
Add the Service Provider and alias manually to your
`config/app` file in the `providers` section.

```php
'providers' => [
    //...
    Merdanio\GatewayTM\Payment\Providers\GatewayServiceProvider::class,
]
```
```php
    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
        'Gateway' => Merdanio\GatewayTM\Payment\Facades\GatewayFacade::class
    ])->toArray(),
```
Publish the config

```bash
php artisan vendor:publish --tag="gateway"
```

Please configure the following credentials in your .env file, which you will obtain from the bank.

`ALTYN_ASYR_USER=`
`ALTYN_ASYR_PASSWORD=`
`ALTYN_ASYR_API=`
`ALTYN_ASYR_ORDER_URI='register.do'`
`ALTYN_ASYR_STATUS_URI='orderStatus.do'`

`RYSGAL_USER=`
`RYSGAL_PASSWORD=`
`RYSGAL_API=`
`RYSGAL_ORDER_URI='register.do'`
`RYSGAL_STATUS_URI=`

`SENAGAT_USER=`
`SENAGAT_PASSWORD=`
`SENAGAT_API=`
`SENAGAT_ORDER_URI='register.do'`
`SENAGAT_STATUS_URI='orderStatus.do'`

## Usage
Add Gateway facade to your class, controller
```php
use Gateway;

class MyController extends Controller {

    public function index() {
        return Gateway::availableGates();
    }
}
```
### Available payment providers

```php
Gateway::availableGates();
```
### Register order
```php
Gateway::registerOrder('rysgal', // providers code
    'success_route_name',        // route to return when payment is successful
    'fail_route_name',           // route to return when payment failed
    14500,                       // payment amount 145 man.
    'Example Ecommerse payment', // payment description
    'ord-123'                    // payment order number
);
```
### Check payment status
```php
Gateway::getOrderStatus(
    'rysgal', //providers code
    'ord-123' //order number
);
```

## License
Is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
