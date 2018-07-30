<?php

namespace GermanoZambelli\Hassio\Credentials;

use GermanoZambelli\Hassio\Exception\InvalidUriArgumentException;

class ApiCredentials extends AbstractCredentials
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $password;


    /**
     * ApiCredentials constructor.
     * @param string $uri
     * @param string $password
     * @throws InvalidUriArgumentException
     */
    public function __construct(string $uri, string $password)
    {
        if (!parent::isValidUri($uri))
            throw new InvalidUriArgumentException(sprintf("%s isn't a valid uri", $uri));
        $this->uri = $uri;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}