<?php

use GermanoZambelli\Hassio\Credentials\ConfiguratorCredentials;
use GermanoZambelli\Hassio\Hassio;

include __DIR__ . '/../vendor/autoload.php';

$configuratorCredentials = new ConfiguratorCredentials('http://ipaddress:port', 'username', 'password');

$hassio = new Hassio(null, $configuratorCredentials);

$fileContent = "put your content here";

var_dump($hassio->saveConfigFile('automations.yaml', $fileContent));