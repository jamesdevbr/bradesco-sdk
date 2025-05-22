<?php

namespace JamesDevBR\BradescoSDK\Services\Resources;

use JamesDevBR\BradescoSDK\Services\Traits\ErrorTrait;
use JamesDevBR\BradescoSDK\Services\Bradesco;
use JamesDevBR\BradescoSDK\Services\DTOs\Order;
use JamesDevBR\BradescoSDK\Services\DTOs\Buyer;

/**
 * Class PixResource
 * Resource for creating PIX transactions.
 */

class PixResource
{
    use ErrorTrait;

    /**
     * @var Bradesco
     */
    private $bradesco;

    /**
     * PixResource constructor.
     *
     * @param Bradesco $bradesco
     */
    public function __construct(Bradesco $bradesco)
    {
        $this->bradesco = $bradesco;
    }

    /**
     * Create a PIX transaction.
     *
     * @param Order $order
     * @param Buyer $buyer
     * @param string|null $tokenRequest
     * @return mixed|false
     */
    public function create(Order $order, Buyer $buyer, $tokenRequest = null)
    {
        $path = '/apipix/transacao';

        $data = [
            'merchant_id' => $this->bradesco->getMerchantId(),
            'meio_pagamento' => '1200',
            'pedido' => $order,
            'comprador' => $buyer,
        ];

        if ($tokenRequest) {
            $data['token_request_confirmacao_pagamento'] = $tokenRequest;
        }

        $responseBody = $this->bradesco->request('POST', $path, [
            'json' => $data,
        ]);

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
