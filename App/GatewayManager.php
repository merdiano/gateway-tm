<?php

namespace Merdiano\Payment\App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Merdiano\Payment\Gateways\IRegistrationResult;
use Exception;
use Merdiano\Payment\Gateways\PaymentStatus;
use Merdiano\Payment\Gateways\RegistrationResult;

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

        foreach (config('gateways') as $gatewatMethod) {
            $object = new $gatewatMethod['class'];

            if (! $object->isAvailable()) {
                continue;
            }

            $gateways[] = [
                'code' => $object->getCode(),
                'title' => $object->getTitle(),
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

        try {
            $httpClient = $this->http_client($gatewayClient->getConfigData('api'));

            $params = $gatewayClient->orderParams($success_route_name, $failure_route_name);

            $response = $httpClient->post($gatewayClient->getConfigData('order_uri'),$params);

            $result = json_decode($response->getBody(),true);

            return $gatewayClient->registrationResult($result);

        }catch (Exception $e){
            Log::error($e);

            return new RegistrationResult(false,$e->getMessage());
        }
    }

    /**
     * Get payment status of order from gateway
     *
     * @param string $code
     * @param string $orderId
     */
    public function getOrderStatus(string $code, string $orderId)
    {
        $gatewayClient = GatewayFactory::create($code,$orderId);

        try{
            $httpClient = $this->http_client($gatewayClient->getConfigData('api'));

            $response = $httpClient->post($gatewayClient->getConfigData('status_uri'),$gatewayClient->statusParams($orderId));

            $result = json_decode($response->getBody(),true);

            return $gatewayClient->paymentStatus($result);

        }catch(Exception $e){
            Log::error($e);

            return new PaymentStatus(false, $e->getMessage());
        }
    }

    /**
     * Prepare Http Client
     *
     * @param string $url
     * @return Client
     */
    private function http_client(string $url) : Client
    {
        return new Client([
            'base_uri' => $url,
            'connect_timeout' => config('gateway.http_client.connect_timeout'),
            'timeout' => config('gateway.http_client.connect_timeout'),
            'verify' => config('gateway.http_client.connect_timeout'),
        ]);
    }
}
