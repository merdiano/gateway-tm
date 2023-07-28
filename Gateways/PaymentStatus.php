<?php

namespace Merdiano\Payment\Gateways;

class PaymentStatus implements IPaymentStatus
{
    public function __construct(protected bool $success, protected string $message = "")
    {
    }


}
