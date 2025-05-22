<?php

namespace JamesDevBR\BradescoSDK\Services\DTOs;

use JsonSerializable;

/**
 * Class Buyer
 * DTO for storing buyer information.
 */
class Buyer implements JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $document;

    /**
     * @var Address|null
     */
    private $address = null;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * Gets the buyer's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the buyer's name.
     *
     * @param string $name
     * @return Buyer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the buyer's document.
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Sets the buyer's document.
     *
     * @param string $document
     * @return Buyer
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Gets the buyer's address.
     *
     * @return Address|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the buyer's address.
     *
     * @param Address $address
     * @return Buyer
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Gets the buyer's IP.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Sets the buyer's IP.
     *
     * @param string $ip
     * @return Buyer
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Gets the buyer's User-Agent.
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Sets the buyer's User-Agent.
     *
     * @param string $userAgent
     * @return Buyer
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

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
            'nome' => $this->getName(),
            'documento' => $this->getDocument(),
            'endereco' => is_object($this->address) ? $this->getAddress()->toArray() : null,
            'ip' => $this->getIp(),
            'user_agent' => $this->getUserAgent(),
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
