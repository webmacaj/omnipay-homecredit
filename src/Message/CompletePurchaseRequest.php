<?php

declare(strict_types=1);

namespace Omnipay\HomeCredit\Message;

/**
 * HomeCredit CompletePurchase Request.
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    /**
     * Get the raw data array for the message.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->httpRequest->query->all();
    }

    /**
     * Send the request with specified data.
     *
     * @param mixed
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    public function sendData($data)
    {
        $this->_authenticate();

        try {
            $request = $this->httpClient->post($this->getEndpoint() . '/applications/' . $this->getData()['applicationId'], [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->_accessToken
            ]);
            $response = $request->send();
            $responseData = $response->json();
        } catch (\Exception $e) {
            throw new \Exception('Application detail request failed. Reason: ' . $e->getMessage());
        }

        return $this->response = new CompletePurchaseResponse($this, $responseData);
    }
}
