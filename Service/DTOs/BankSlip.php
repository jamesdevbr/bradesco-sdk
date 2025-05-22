<?php

namespace JamesDevBR\BradescoSDK\Services\DTOs;

use JsonSerializable;

/**
 * Class BankSlip
 * DTO for storing bank slip information.
 */
class BankSlip implements JsonSerializable
{
    /**
     * @var string
     */
    private $beneficiaryName;

    /**
     * @var int
     */
    private $wallet;

    /**
     * @var string
     */
    private $bankNumber;

    /**
     * @var string
     */
    private $issueDate;

    /**
     * @var string
     */
    private $dueDate;

    /**
     * @var int
     */
    private $nominalValue;

    /**
     * @var string
     */
    private $headerMessage;

    /**
     * @var string
     */
    private $renderingType;

    /**
     * Gets the beneficiary name.
     *
     * @return string
     */
    public function getBeneficiaryName()
    {
        return $this->beneficiaryName;
    }

    /**
     * Sets the beneficiary name.
     *
     * @param string $beneficiaryName
     * @return BankSlip
     */
    public function setBeneficiaryName($beneficiaryName)
    {
        $this->beneficiaryName = $beneficiaryName;

        return $this;
    }

    /**
     * Gets the wallet.
     *
     * @return int
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * Sets the wallet.
     *
     * @param int $wallet
     * @return BankSlip
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * Gets the bank number.
     *
     * @return string
     */
    public function getBankNumber()
    {
        return $this->bankNumber;
    }

    /**
     * Sets the bank number.
     *
     * @param string $bankNumber
     * @return BankSlip
     */
    public function setBankNumber($bankNumber)
    {
        $this->bankNumber = str_pad($bankNumber, 11, '0', STR_PAD_LEFT);

        return $this;
    }

    /**
     * Gets the issue date.
     *
     * @return string
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * Sets the issue date.
     *
     * @param string $issueDate
     * @return BankSlip
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    /**
     * Gets the due date.
     *
     * @return string
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Sets the due date.
     *
     * @param string $dueDate
     * @return BankSlip
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Gets the nominal value.
     *
     * @return int
     */
    public function getNominalValue()
    {
        return $this->nominalValue;
    }

    /**
     * Sets the nominal value.
     *
     * @param int $nominalValue
     * @return BankSlip
     */
    public function setNominalValue($nominalValue)
    {
        $this->nominalValue = $nominalValue;

        return $this;
    }

    /**
     * Gets the header message.
     *
     * @return string
     */
    public function getHeaderMessage()
    {
        return $this->headerMessage;
    }

    /**
     * Sets the header message.
     *
     * @param string $headerMessage
     * @return BankSlip
     */
    public function setHeaderMessage($headerMessage)
    {
        $this->headerMessage = $headerMessage;

        return $this;
    }

    /**
     * Gets the rendering type.
     *
     * @return string
     */
    public function getRenderingType()
    {
        return $this->renderingType;
    }

    /**
     * Sets the rendering type.
     *
     * @param string $renderingType
     * @return BankSlip
     */
    public function setRenderingType($renderingType)
    {
        $this->renderingType = $renderingType;

        return $this;
    }

    /**
     * Converts the object to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'beneficiario' => $this->getBeneficiaryName(),
            'carteira' => $this->getWallet(),
            'nosso_numero' => $this->getBankNumber(),
            'data_emissao' => $this->getIssueDate(),
            'data_vencimento' => $this->getDueDate(),
            'valor_titulo' => $this->getNominalValue(),
            'mensagem_cabecalho' => $this->getHeaderMessage(),
            'tipo_renderizacao' => $this->getRenderingType(),
        ];

        return array_filter($data);
    }

    /**
     * Specifies the data to be serialized to JSON.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}