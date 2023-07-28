<?php
namespace Merdiano\Payment\App;

use Merdiano\Payment\Gateways\AbstractGateway;
use Merdiano\Payment\Gateways\IGateway;

class GatewayFactory
{
    /**
     * Create payment gateway
     *
     * @param  string  $code
     * @return IGateway
     */
    public static function create(string $code, string $order_id):AbstractGateway
    {
        $class = config('gateway.clients.'.$code.'.class');
        $gateway = new $class($order_id);

        return $gateway;
    }

}
