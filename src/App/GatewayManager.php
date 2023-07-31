<?php

namespace Merdanio\GatewayTM\Payment\App;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Merdanio\GatewayTM\Payment\Gateways\IPaymentStatus;
use Merdanio\GatewayTM\Payment\Gateways\IRegistrationResult;
use Merdanio\GatewayTM\Payment\Gateways\PaymentStatus;
use Merdanio\GatewayTM\Payment\Gateways\RegistrationResult;

class GatewayManager
{
    /**
     * Returns active gateways.
     *
     * @return array
     */
    public function availableGates() : array
    {
        $gateways = [];

        foreach (config('gateway.clients') as $gatewayMethod) {
            if (! $gatewayMethod['active']) {
                continue;
            }

            $gateways[] = [
                'code' => $gatewayMethod['code'],
                'title' => trans($gatewayMethod['title']),
            ];
        }
        return $gateways;
    }

    /**
     * Registers Payment order to bank gateway
     *
     * @param string $code
     * @param int $amount
     * @param string $description
     * @param string $orderId
     * @return IRegistrationResult
     */
    public function registerOrder(string $code,
                                  string $success_route_name,
                                  string $failure_route_name,
                                  int $amount,
                                  string $description,
                                  string $orderId) : IRegistrationResult
    {
        $gatewayClient = GatewayFactory::create($code,$orderId);

        $gatewayClient->setAmount($amount);
        $gatewayClient->setDescription($description);

        $response = Http::retry(3,300)
            ->asForm()
            ->post(
                $gatewayClient->getConfigData('order_uri'),
                $gatewayClient->orderParams($success_route_name,$failure_route_name)
            );

        if($response->failed()){
            $ex = $response->toException();

            return new RegistrationResult(false, $ex->getMessage());
        }

        return $gatewayClient->registrationResult($response);

    }

    /**
     * Get payment status of order from gateway
     *
     * @param string $code
     * @param string $orderId
     */
    public function getOrderStatus(string $code, string $orderId) : IPaymentStatus
    {
        $gatewayClient = GatewayFactory::create($code,$orderId);

        $response = Http::retry(3,300)
            ->asForm()
            ->post(
                $gatewayClient->getConfigData('status_uri'),
                $gatewayClient->statusParams($orderId)
            );

        if($response->failed()){
            $ex = $response->toException();

            return new PaymentStatus(false, $ex->getMessage());
        }

        return $gatewayClient->paymentStatus($response);

    }
}
