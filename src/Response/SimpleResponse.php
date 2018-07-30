<?php

namespace GermanoZambelli\Hassio\Model;

class SimpleResponse implements ResponseInterface
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * SimpleResponse constructor.
     * @param null|string $message
     * @param int $statusCode
     */
    public function __construct(int $statusCode, ?string $message)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return ($this->statusCode == 401);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}