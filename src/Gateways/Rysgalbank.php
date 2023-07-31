<?php

namespace Merdanio\GatewayTM\Payment\Gateways;

class Rysgalbank extends AbstractGateway
{
    /**
     * Gateway code.
     *
     * @var string
     */
    protected $code = 'rysgal';


    function makeOrderParams(): array
    {
        // TODO: Implement getRequestParams() method.
    }

    public function registrationResult(array $data): IRegistrationResult
    {
        // TODO: Implement registrationResult() method.
    }
}
