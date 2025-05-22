<?php

namespace JamesDevBR\BradescoSDK\Services\Traits;

/**
 * ErrorTrait
 * Trait for handling error messages and exceptions in services.
 */
trait ErrorTrait
{
    /**
     * @var string
     */
    private $errorMessage = '';

    /**
     * @var mixed
     */
    private $exception = null;

    /**
     * Define a error message e a exceção associada.
     *
     * @param string $message
     * @param mixed $exception
     * @return void
     */
    public function setError($message, $exception = null)
    {
        $this->errorMessage = $message;
        $this->exception = $exception;
    }

    /**
     * Gets the error message.
     *
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Gets the exception.
     *
     * @return mixed
     */
    public function getException()
    {
        return $this->exception;
    }
}
