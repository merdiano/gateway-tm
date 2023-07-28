<?php

namespace Merdiano\Payment\Gateways;

interface IRegistrationResult
{
    function isSuccessful() : bool;

    function getMessage() : string;

    function getRedirectUrl() : string;

    function getOrderId() : string;
}
