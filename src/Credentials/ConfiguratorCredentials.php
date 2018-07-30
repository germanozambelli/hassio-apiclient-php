<?php

namespace GermanoZambelli\Hassio\Credentials;

use GermanoZambelli\Hassio\Exception\InvalidUriArgumentException;

class ConfiguratorCredentials extends AbstractCredentials
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * ConfiguratorCredentials constructor.
     * @param string $uri
     * @param string $username
     * @param string $password
     * @throws InvalidUriArgumentException
     */
    public function __construct(string $uri, string $username, string $password)
    {
        if (!parent::isValidUri($uri))
            throw new InvalidUriArgumentException(sprintf("%s isn't a valid uri", $uri));
        $this->uri = $uri;
        $this->username = $username;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}