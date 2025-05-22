<?php

namespace JamesDevBR\BradescoSDK\Services\Resources;

use JamesDevBR\BradescoSDK\Services\Bradesco;
use JamesDevBR\BradescoSDK\Services\Traits\ErrorTrait;

/**
 * Class OrderResource
 * Resource for handling orders.
 */

class OrderResource
{
    use ErrorTrait;

    public const BANKSLIP = 'boleto';
    public const PIX = 'pix';

    /**
     * @var Bradesco
     */
    private $bradesco;

    /**
     * OrderResource constructor.
     *
     * @param Bradesco $bradesco
     */
    public function __construct(Bradesco $bradesco)
    {
        $this->bradesco = $bradesco;
    }

    /**
     * Order List
     *
     * @param string $type
     * @param string $startDate Formato Y/m/d
     * @param string $endDate Formato Y/m/d
     * @param int $status
     * @return mixed|false
     */
    public function list($type, $startDate, $endDate, $status = 1)
    {
        $path = '/SPSConsulta/GetOrderList/' . $this->bradesco->getMerchantId() . '/' . $type;

        $responseBody = $this->bradesco->request('GET', $path, [
            'query' => [
                'dataInicial' => $startDate,
                'dataFinal' => $endDate,
                'status' => $status,
            ],
        ], true);

        if (!$responseBody) {
            $this->setError(
                $this->bradesco->getErrorMessage(),
                $this->bradesco->getException()
            );

            return false;
        }

        return $responseBody;
    }

    /**
     * List the Order Payments
     *
     * @param string $type
     * @param string $startDate Formato Y/m/d
     * @param string $endDate Formato Y/m/d
     * @param int $status
     * @param int $offset
     * @param int $limit
     * @return mixed|false
     */
    public function listPayment($type, $startDate, $endDate, $status, $offset, $limit)
    {
        $path = '/SPSConsulta/GetOrderListPayment/' . $this->bradesco->getMerchantId() . '/' . $type;

        $responseBody = $this->bradesco->request('GET', $path, [
            'query' => [
                'dataInicial' => $startDate,
                'dataFinal' => $endDate,
                'status' => $status,
                'offset' => $offset,
                'limit' => $limit,
            ],
        ], true);

        if (!$responseBody) {
            $this->setError(
                $this->bradesco->getErrorMessage(),
                $this->bradesco->getException()
            );

            return false;
        }

        return $responseBody;
    }

    /**
     * Retrieves order details by ID.
     *
     * @param string $orderId
     * @return mixed|false
     */
    public function getById($orderId)
    {
        $path = '/SPSConsulta/GetOrderById/' . $this->bradesco->getMerchantId();

        $responseBody = $this->bradesco->request('GET', $path, [
            'query' => [
                'orderId' => $orderId,
            ],
        ], true);

        if (!$responseBody) {
            $this->setError(
                $this->bradesco->getErrorMessage(),
                $this->bradesco->getException()
            );

            return false;
        }

        return $responseBody;
    }
}
