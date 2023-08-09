<?php

namespace Merdanio\GatewayTM\Payment\Gateways;

class PaymentStatus implements IPaymentStatus
{
    public function __construct(protected bool $success, protected string $message = "")
    {
    }


    function getStatus(): bool
    {
        return $this->success;
    }

    function getMessage(): string
    {
       return $this->message;
    }
}
