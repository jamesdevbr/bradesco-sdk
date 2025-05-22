<?php

namespace JamesDevBR\BradescoSDK\Services\DTOs;

use JsonSerializable;

/**
 * Class Order
 * DTO for storing order information.
 */
class Order implements JsonSerializable
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var int
     */
    private $value;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $format;

    /**
     * @var int
     */
    private $expiration;

    /**
     * Gets the order number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Order identifier in the store.
     * Format: Alphanumeric with at least 1 digit.
     *
     * @param string $number
     * @return Order
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Gets the order value in cents.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Order value expressed in cents.
     * Example: 1500 refers to the amount of R$ 15.00.
     *
     * @param int $value
     * @return Order
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Gets the purchase description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Purchase description.
     * Example: Kit 2 Cartridges.
     *
     * @param string $description
     * @return Order
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the payment display format.
     *
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Payment display format:
     * 1 = With Bradesco logo;
     * 2 = Without Bradesco logo;
     * 3 = Data for interface customization.
     * If the value is invalid or null, 1 is assumed.
     *
     * @param int $format
     * @return Order
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Gets the Pix expiration time in seconds.
     *
     * @return int
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Sets the Pix expiration time in seconds.
     * Minimum value: 1 minute (60 seconds).
     * Maximum value: 100 days.
     * The “expiracao” tag cannot be used together with the “vencimento” tag.
     *
     * @param int $expiration
     * @return Order
     */
    public function setExpiration($expiration)
    {
        $expiration = max(60, $expiration);
        $this->expiration = min(8640000, $expiration);

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
            'numero' => $this->getNumber(),
            'valor' => $this->getValue(),
            'descricao' => $this->getDescription(),
            'formato' => $this->getFormat(),
            'expiracao' => $this->getExpiration(),
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
