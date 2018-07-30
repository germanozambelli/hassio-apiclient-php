<?php

namespace GermanoZambelli\Hassio\Response;

class SaveConfigFileResponse extends SimpleResponse
{
    /**
     * @var bool
     */
    private $error;

    /**
     * @var string
     */
    private $file;

    /**
     * SaveConfigFileResponse constructor.
     * @param bool $error
     * @param string $message
     * @param string $file
     * @param int $statusCode
     */
    public function __construct(bool $error, string $message, string $file, int $statusCode)
    {
        $this->error = $error;
        $this->file = $file;
        parent::__construct($statusCode, $message);
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }
}