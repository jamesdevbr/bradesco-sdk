<?php

namespace JamesDevBR\BradescoSDK\Services;

use JamesDevBR\BradescoSDK\Services\Resources\BankSlipResource;
use JamesDevBR\BradescoSDK\Services\Resources\NotificationResource;
use JamesDevBR\BradescoSDK\Services\Resources\OrderResource;
use JamesDevBR\BradescoSDK\Services\Resources\PixResource;
use JamesDevBR\BradescoSDK\Services\Traits\ErrorTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Bradesco
 * Main class for integration with Bradesco services.
 */

class Bradesco
{
    use ErrorTrait;

    public const SANDBOX = 'sandbox';
    public const PRODUCTION = 'production';

    /**
     * @var array
     */
    protected $url = [
        'production' => 'https://meiosdepagamentobradesco.com.br',
        'sandbox' => 'https://homolog.meiosdepagamentobradesco.com.br',
    ];

    /**
     * @var string
     */
    private $baseUrl = '';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var OrderResource
     */
    private $orderResource;

    /**
     * @var BankSlipResource
     */
    private $bankSlipResource;

    /**
     * @var PixResource
     */
    private $pixResource;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $securityKey;

    /**
     * @var string|null
     */
    private $email;

    /**
     * Bradesco constructor.
     *
     * @param string $mode
     * @param string $merchantId
     * @param string $securityKey
     * @param string|null $email
     */
    public function __construct($mode, $merchantId, $securityKey, $email = null)
    {
        $this->mode = $mode;
        $this->merchantId = $merchantId;
        $this->securityKey = $securityKey;
        $this->email = $email;
    }

    /**
     * Gets the base URL based on the mode (sandbox or production).
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getMode() === self::PRODUCTION ? $this->url['production'] : $this->url['sandbox'];
    }

    /**
     * Creates a new Guzzle HTTP client instance.
     *
     * @return Client
     */
    private function getClient()
    {
        if (isset($this->client)) {
            return $this->client;
        }

        return $this->client = new Client([
            'base_uri' => $this->getBaseUrl(),
            'timeout' => 60.0,
            'debug' => false,
        ]);
    }

    /**
     * Gets the mode (sandbox or production).
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Get the merchant ID.
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * Get the email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the security key.
     *
     * @return string
     */
    public function getSecurityKey()
    {
        return $this->securityKey;
    }

    /**
     * Verify if the current mode is sandbox.
     *
     * @return bool
     */
    public function isSandbox()
    {
        return $this->mode === self::SANDBOX;
    }

    /**
     * Make a request to the Bradesco API.
     *
     * @param string $method
     * @param string $url
     * @param array $options
     * @param bool $userAsEmail
     * @return mixed|false
     */
    public function request($method, $url, $options = [], $userAsEmail = false)
    {
        $client = $this->getClient();

        if ($userAsEmail) {
            $token = $this->token();

            if (!$token) {
                return false;
            }

            $options['query']['token'] = $token;
        }

        $options = $this->getDefaultOptions($userAsEmail, $options);

        try {
            $res = $client->request($method, $url, $options);

            return json_decode($res->getBody());

        } catch (RequestException $e) {
            $this->handleRequestException($e);

            return false;

        } catch (GuzzleException $e) {
            $this->handleGuzzleException($e);

            return false;
        }
    }

    /**
     * Gets the token for authentication.
     *
     * @return string|bool
     */
    private function token()
    {
        $client = $this->getClient();

        $options = $this->getDefaultOptions(true);

        $url = $this->baseUrl . '/SPSConsulta/Authentication/' . $this->merchantId;

        try {
            $res = $client->request('GET', $url, $options);

            $body = json_decode($res->getBody());

            if (empty($body->token->token)) {
                $this->setError($body->status->mensagem ?? "Bradesco's response did not return any token.");

                return false;
            }

            return $body->token->token;

        } catch (RequestException $e) {
            $this->handleRequestException($e);

            return false;

        } catch (GuzzleException $e) {
            $this->handleGuzzleException($e);

            return false;
        }
    }

    /**
     * Get default options for the request.
     *
     * @param bool $userAsEmail
     * @param array $customOptions
     * @return array
     */
    private function getDefaultOptions($userAsEmail, array $customOptions = [])
    {
        return array_merge([
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
            'auth' => [
                $userAsEmail ? $this->getEmail() : $this->getMerchantId(),
                $this->getSecurityKey(),
            ],
        ], $customOptions);
    }

    /**
     * Handles exceptions of type RequestException.
     *
     * @param RequestException $e
     * @return void
     */
    private function handleRequestException(RequestException $e)
    {
        if ($e->hasResponse()) {
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);

            $this->setError($body['status']['mensagem'] ?? $e->getMessage(), $e);
        } else {
            $this->setError($e->getMessage(), $e);
        }
    }

    /**
     * Handles exceptions of type GuzzleException.
     *
     * @param GuzzleException $e
     * @return void
     */
    private function handleGuzzleException(GuzzleException $e)
    {
        $this->setError($e->getMessage(), $e);
    }

    /**
     * Returns an instance of OrderResource.
     *
     * @return OrderResource
     */
    public function orderResource()
    {
        return $this->orderResource ?? $this->orderResource = new OrderResource($this);
    }

    /**
     * Returns an instance of BankSlipResource.
     *
     * @return BankSlipResource
     */
    public function bankSlipResource()
    {
        return $this->bankSlipResource ?? $this->bankSlipResource = new BankSlipResource($this);
    }

    /**
     * Returns an instance of PixResource.
     *
     * @return PixResource
     */
    public function pixResource()
    {
        return $this->pixResource ?? $this->pixResource = new PixResource($this);
    }

    /**
     * Creates a new instance of BankSlip DTO.
     *
     * @return DTOs\BankSlip
     */
    public function bankSlip()
    {
        return new DTOs\BankSlip;
    }

    /**
     * Creates a new instance of Order DTO.
     *
     * @return DTOs\Order
     */
    public function order()
    {
        return new DTOs\Order;
    }

    /**
     * Creates a new instance of Address DTO.
     *
     * @return DTOs\Address
     */
    public function address()
    {
        return new DTOs\Address;
    }

    /**
     * Creates a new instance of Buyer DTO.
     *
     * @return DTOs\Buyer
     */
    public function buyer()
    {
        return new DTOs\Buyer;
    }

    /**
     * Creates a new instance of Notification DTO.
     *
     * @return NotificationResource
     */
    public static function notification()
    {
        return new NotificationResource;
    }
}
