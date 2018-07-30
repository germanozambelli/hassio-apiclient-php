<?php

namespace GermanoZambelli\Hassio\Response;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return bool
     */
    public function isError(): bool;

    /**
     * @return int
     */
    public function getStatusCode(): int;
}