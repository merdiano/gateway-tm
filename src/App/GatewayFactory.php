<?php
namespace Merdanio\GatewayTM\Payment\App;

use Merdanio\GatewayTM\Payment\Gateways\AbstractGateway;
use Merdanio\GatewayTM\Payment\Gateways\IGateway;

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
