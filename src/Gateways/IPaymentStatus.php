<?php

namespace Merdanio\GatewayTM\Payment\Gateways;

interface IPaymentStatus
{
    function getStatus(): bool;
    function getMessage(): string;
}
