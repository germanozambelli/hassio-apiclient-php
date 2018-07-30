<?php

namespace GermanoZambelli\Hassio\Response;

class ValidationConfigResponse extends SimpleResponse
{
    /**
     * @var bool
     */
    private $valid;

    /**
     * ValidationConfigResponse constructor.
     * @param string $result
     * @param null|string $message
     * @param int $statusCode
     */
    public function __construct(string $result, ?string $message, int $statusCode)
    {
        $this->valid = ($result != 'invalid');
        parent::__construct($statusCode, $message);
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return !$this->valid;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid();
    }
}