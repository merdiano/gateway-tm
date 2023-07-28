<?php
namespace Merdanio\GatewayTM\Payment\Facades;
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
