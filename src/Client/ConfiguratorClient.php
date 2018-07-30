<?php

namespace GermanoZambelli\Hassio\Client;

use GermanoZambelli\Hassio\Credentials\ConfiguratorCredentials;
use GermanoZambelli\Hassio\Exception\ConnectionException;
use GermanoZambelli\Hassio\Exception\WrongConfiguratorCredentialsException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface;

class ConfiguratorClient extends Client
{
    const API_ENDPOINT = "/api/";

    /**
     * @var ConfiguratorCredentials
     */
    private $configuratorCredentials;


    /**
     * ConfiguratorClient constructor.
     * @param ConfiguratorCredentials $configuratorCredentials
     */
    public function __construct(ConfiguratorCredentials $configuratorCredentials)
    {
        $this->configuratorCredentials = $configuratorCredentials;
        $config['base_uri'] = $this->getBaseUri();
        $config['auth'][0] = $this->configuratorCredentials->getUsername();
        $config['auth'][1] = $this->configuratorCredentials->getPassword();
        parent::__construct($config);
    }

    /**
     * @return string
     */
    private function getBaseUri(): string
    {
        return $this->configuratorCredentials->getUri() . self::API_ENDPOINT;
    }

    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws ConnectionException
     * @throws WrongConfiguratorCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri = '', array $options = []): ResponseInterface
    {
        try {
            return parent::request($method, $uri, $options);
        } catch (ConnectException $ex) {
            throw new ConnectionException(sprintf("Failed to connect to %s", $this->getBaseUri() . $uri));
        } catch (ClientException $ex) {
            if ($ex->getCode() == 401)
                throw new WrongConfiguratorCredentialsException("Unauthorized access with this configurator credentials");
        }
    }
}