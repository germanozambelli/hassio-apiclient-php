<?php

namespace GermanoZambelli\Hassio;

use GermanoZambelli\Hassio\Client\ApiClient;
use GermanoZambelli\Hassio\Client\ConfiguratorClient;
use GermanoZambelli\Hassio\Credentials\ApiCredentials;
use GermanoZambelli\Hassio\Credentials\ConfiguratorCredentials;
use GermanoZambelli\Hassio\Exception\ErrorInSaveConfigFileException;
use GermanoZambelli\Hassio\Model\Entity;
use GermanoZambelli\Hassio\Response\EntitiesStateResponse;
use GermanoZambelli\Hassio\Response\SaveConfigFileResponse;
use GermanoZambelli\Hassio\Response\SimpleResponse;
use GermanoZambelli\Hassio\Response\ValidationConfigResponse;

class Hassio
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var ConfiguratorClient
     */
    private $configuratorClient;

    /**
     * Hassio constructor.
     * @param ApiCredentials $apiCredentials
     * @param ConfiguratorCredentials|null $configuratorCredentials
     */
    public function __construct(?ApiCredentials $apiCredentials, ?ConfiguratorCredentials $configuratorCredentials = null)
    {
        if ($apiCredentials)
            $this->apiClient = new ApiClient($apiCredentials);

        if ($configuratorCredentials)
            $this->configuratorClient = new ConfiguratorClient($configuratorCredentials);
    }

    /**
     * @return string
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\MethodNotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\WrongApiCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getConfig(): string
    {
        $response = $this->apiClient->request('GET', 'config');
        return new SimpleResponse($response->getStatusCode(), $response->getBody()->getContents());
    }

    /**
     * @return ValidationConfigResponse
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\MethodNotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\WrongApiCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function validationConfigFiles(): ValidationConfigResponse
    {
        $response = $this->apiClient->request('POST', 'config/core/check_config');
        $decodedResponse = json_decode($response->getBody()->getContents());
        return new ValidationConfigResponse($decodedResponse->result, $decodedResponse->errors, $response->getStatusCode());
    }

    /**
     * @param string $fileName
     * @return SimpleResponse
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\MethodNotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\WrongConfiguratorCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getConfigFile(string $fileName): SimpleResponse
    {
        $response = $this->configuratorClient->request('GET', 'file?filename=/config/' . $fileName, []);
        return new SimpleResponse($response->getStatusCode(), $response->getBody()->getContents());
    }

    /**
     * @param string $fileName
     * @param string $content
     * @return SaveConfigFileResponse
     * @throws ErrorInSaveConfigFileException
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\MethodNotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\WrongConfiguratorCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function saveConfigFile(string $fileName, string $content): SaveConfigFileResponse
    {
        $response = $this->configuratorClient->request('POST', 'save', ['form_params' => ['filename' => '/config/' . $fileName, 'text' => $content]]);
        $decodedResponse = json_decode($response->getBody()->getContents());
        $saveConfigFileResponse = new SaveConfigFileResponse($decodedResponse->error, $decodedResponse->message, $decodedResponse->file, $response->getStatusCode());
        if ($saveConfigFileResponse->isError())
            throw new ErrorInSaveConfigFileException($decodedResponse->message);
        return $saveConfigFileResponse;
    }

    /**
     * @param string $domain
     * @param string $service
     * @param array $data
     * @return SimpleResponse
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\MethodNotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\WrongApiCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callService(string $domain, string $service, array $data): SimpleResponse
    {
        $response = $this->apiClient->request('POST', 'services/' . $domain . "/" . $service, ['body' => json_encode($data)]);
        return new SimpleResponse($response->getStatusCode(), $response->getBody()->getContents());
    }

    /**
     * @param Entity $entity
     * @return SimpleResponse
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\MethodNotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\WrongApiCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function turnOnEntity(Entity $entity): SimpleResponse
    {
        return $this->callService($entity->getDomain(), 'turn_on', ['entity_id' => $entity->getEntityId()]);
    }

    /**
     * @param Entity $entity
     * @return SimpleResponse
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\MethodNotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\WrongApiCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function turnOffEntity(Entity $entity): SimpleResponse
    {
        return $this->callService($entity->getDomain(), 'turn_off', ['entity_id' => $entity->getEntityId()]);
    }

    /**
     * @return EntitiesStateResponse
     * @throws Exception\BadRequestException
     * @throws Exception\ConnectionException
     * @throws Exception\MethodNotAllowedException
     * @throws Exception\NotFoundException
     * @throws Exception\WrongApiCredentialsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEntitiesState(): EntitiesStateResponse
    {
        $response = $this->apiClient->request('GET', 'states', []);
        return new EntitiesStateResponse($response->getStatusCode(), $response->getBody()->getContents());
    }
}