<?php

namespace JamesDevBR\BradescoSDK\Services\Resources;

use JamesDevBR\BradescoSDK\Services\Traits\ErrorTrait;
use JamesDevBR\BradescoSDK\Services\Bradesco;
use JamesDevBR\BradescoSDK\Services\DTOs\Order;
use JamesDevBR\BradescoSDK\Services\DTOs\Buyer;
use JamesDevBR\BradescoSDK\Services\DTOs\BankSlip;

/**
 * Class BankSlipResource
 * Recurso para criar boletos bancários.
 */
class BankSlipResource
{
    use ErrorTrait;

    /**
     * @var Bradesco
     */
    private $bradesco;

    /**
     * BankSlipResource constructor.
     *
     * @param Bradesco $bradesco
     */
    public function __construct(Bradesco $bradesco)
    {
        $this->bradesco = $bradesco;
    }

    /**
     * Creates a bank slip.
     *
     * @param Order $order
     * @param Buyer $buyer
     * @param BankSlip $bankSlip
     * @return mixed|false
     */
    public function create(Order $order, Buyer $buyer, BankSlip $bankSlip)
    {
        $path = '/apiboleto/transacao';

        $data = [
            'merchant_id' => $this->bradesco->getMerchantId(),
            'meio_pagamento' => '300',
            'pedido' => $order,
            'comprador' => $buyer,
            'boleto' => $bankSlip,
        ];

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
