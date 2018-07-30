<?php

namespace GermanoZambelli\Hassio\Client;

use GermanoZambelli\Hassio\Credentials\ApiCredentials;
use GermanoZambelli\Hassio\Exception\ConnectionException;
use GermanoZambelli\Hassio\Exception\WrongApiCredentialsException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface;

class ApiClient extends Client
{
    const API_ENDPOINT = "/api/";

    /**
     * @var ApiCredentials
     */
    private $apiCredentials;

    public function __construct(ApiCredentials $apiCredentials)
    {
        $this->apiCredentials = $apiCredentials;
        $config['base_uri'] = $this->getBaseUri();
        $config['headers']['X-HA-access'] = $this->apiCredentials->getPassword();
        parent::__construct($config);
    }

    /**
     * @return string
     */
    private function getBaseUri(): string
    {
        return $this->apiCredentials->getUri() . self::API_ENDPOINT;
    }

    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws ConnectionException
     * @throws WrongApiCredentialsException
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
                throw new WrongApiCredentialsException("Unauthorized access with this credentials");
        }
    }

}