<?php

namespace JamesDevBR\BradescoSDK\Services\DTOs;

use JsonSerializable;

/**
 * Class Address
 * DTO for storing address information.
 */
class Address implements JsonSerializable
{
    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string|null
     */
    private $complement = null;

    /**
     * @var string
     */
    private $neighborhood;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $country = 'BR';

    /**
     * @var string
     */
    private $zipCode;

    /**
     * Gets the street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Gets the number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Gets the complement.
     *
     * @return string|null
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Gets the neighborhood.
     *
     * @return string
     */
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    /**
     * Gets the city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Gets the state.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Gets the country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Gets the ZIP code.
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Sets the street.
     *
     * @param string $street
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = trim($street);

        return $this;
    }

    /**
     * Sets the number.
     *
     * @param string $number
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Sets the complement.
     *
     * @param string $complement
     * @return self
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Sets the neighborhood.
     *
     * @param string $neighborhood
     * @return self
     */
    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = trim($neighborhood);

        return $this;
    }

    /**
     * Sets the city.
     *
     * @param string $city
     * @return self
     */
    public function setCity($city)
    {
        $this->city = trim($city);

        return $this;
    }

    /**
     * Sets the state.
     *
     * @param string $state
     * @return self
     */
    public function setState(string $state): self
    {
        $this->state = trim($state);

        return $this;
    }

    /**
     * Sets the ZIP code.
     *
     * @param string $zipCode
     * @return self
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = substr(preg_replace('/[^0-9]/', '', $zipCode), 0, 8);

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
            'cep' => $this->getZipCode(),
            'logradouro' => $this->getStreet(),
            'numero' => $this->getNumber(),
            'complemento' => $this->getComplement(),
            'bairro' => $this->getNeighborhood(),
            'cidade' => $this->getCity(),
            'uf' => $this->getState(),
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