<?php
namespace Merdanio\GatewayTM\Payment\App;

use Merdanio\GatewayTM\Payment\Gateways\AbstractGateway;

class GatewayFactory
{
    /**
     * Create payment gateway
     *
     * @param  string  $code
     * @return AbstractGateway
     */
    public static function create(string $code, string $order_id):AbstractGateway
    {
        $class = config('gateway.clients.'.$code.'.class');
        $gateway = new $class($order_id);

        return $gateway;
    }

}
