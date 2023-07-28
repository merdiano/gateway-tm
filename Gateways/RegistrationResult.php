<?php

namespace Merdiano\Payment\Gateways;

class RegistrationResult implements IRegistrationResult
{
    /**
     * Registration Result number
     *
     * @var string $orderId
     */
    protected string $orderId;

    /**
     * Redirect url
     *
     * @var string $url
     */
    protected string $url;

    /**
     * Constructor
     *
     * @param bool $success
     * @param string $message
     */
    public function __construct(protected bool $success, protected string $message = ""){}

    function isSuccessful(): bool
    {
        return $this->success;
    }

    function getMessage(): string
    {
        return $this->message;
    }

    function getRedirectUrl(): string
    {
        return $this->url;
    }

    function getOrderId(): string
    {
        return $this->orderId;
    }

    public function setErrorMessage(string $errorMessage) : void
    {
        $this->message = $errorMessage;
    }

    public function setOrderId(string $orderId) : void
    {
        $this->orderId = $orderId;
    }

    public function setFormUrl(string $formUrl) : void
    {
        $this->url = $formUrl;
    }
}
