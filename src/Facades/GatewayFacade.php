<?php
namespace Merdanio\GatewayTM\Payment\Facades;

use Merdanio\GatewayTM\Payment\Gateways\IPaymentStatus;
use Merdanio\GatewayTM\Payment\Gateways\IRegistrationResult;

/**
 * @method static array availableGates()
 * @method static IRegistrationResult registerOrder(string $code, string $success_route_name, string $failure_route_name, int $amount, string $description, string $orderId)
 * @method static IPaymentStatus getOrderStatus(string $code, string $orderId)
 */
class GatewayFacade extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'gateway';
    }
}
