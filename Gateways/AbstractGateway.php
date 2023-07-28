<?php

namespace Merdiano\Payment\Gateways;

use Merdiano\Payment\Exceptions\GatewayCodeException;

abstract class AbstractGateway
{
    /**
     * Payment Gateway code.
     *
     * @var string
     */
    protected $code;

    /**
     * Base Constructor
     *
     * @param string $order_id
     */
    public function __construct(protected $order_id){}
    /**
     * Returns shipping method carrier code.
     *
     * @return string
     */
    public function getCode() : string
    {
        if (empty($this->code)) {
            throw new GatewayCodeException('Gateway code should be initialized.');
        }

        return $this->code;
    }

    /**
     * Returns gateway title.
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->getConfigData('title');
    }

    public function getOrderId() : string {
        return $this->orderId;
    }

    /**
     * Retrieve information from gateway configuration.
     *
     * @param  string  $field
     * @return mixed
     */
    public function getConfigData(string $field)
    {
        return config('gateway.clients.' . $this->getCode() . '.' . $field);
    }

    /**
     * Sets Payment amount (tenge)
     *
     * @param int $amount
     */
    public function setAmount(int $amount) : void
    {
        $this->amount = $amount;
    }

    /**
     * Sets order description
     *
     * @param string $description
     */
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    /**
     * Params to be sent to gateway, to register order
     *
     * @param string $orderId
     * @return array[]
     */
    public function orderParams(string $success_route, string $fail_route) : array
    {
        return [
            'form_params' => [
                'userName' => $this->getConfigData('user'),
                'password' => $this->getConfigData('password'),
                'sessionTimeoutSecs' => config('gateway.http_client.timeout'),
                'orderNumber' =>$this->orderId,
                'currency' => 934,
                'language' => 'ru',
                'description'=> $this->description,
                'amount' => $this->amount,// amount w kopeykah
                'returnUrl' => route($success_route,['orderId' => $this->orderId]),
                'failUrl' => route($fail_route,['orderId'=>$this->orderId])
            ],
        ];
    }

    /**
     * Params to be sent to gateway, to retrieve payment status
     * @param string $orderId
     * @return array[]
     */
    public function statusParams(string $orderId) : array
    {
        return [
            'form_params' => [
                'userName' => $this->getConfigData('user'),
                'password' => $this->getConfigData('password'),
                'orderId' => $orderId,
            ]
        ];
    }

    /**
     * Convert order registration response to RegistrationResult
     * @param array $data
     * @return IRegistrationResult
     */
    public function registrationResult(array $data): IRegistrationResult
    {
        $result = new RegistrationResult(isset($data['orderId']) && isset($data['formUrl']));

        if($result->isSuccessful()){
            $result->setOrderId($data['orderId']);
            $result->setFormUrl($data['formUrl']);
        }
        elseif(isset($data['errorMessage'])){
            $result->setErrorMessage($data['errorMessage']);
        }

        return $result;
    }

    public function paymentStatus(array $data) : IPaymentStatus
    {
        $status = $data['ErrorCode'] == 0 && isset($data['OrderStatus']) && $data['OrderStatus'] == 2;

        $result = new PaymentStatus($status,$data['ErrorMessage']);

        return $result;
    }
}
