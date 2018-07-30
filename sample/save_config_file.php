<?php

use GermanoZambelli\Hassio\Credentials\ConfiguratorCredentials;
use GermanoZambelli\Hassio\Hassio;

include __DIR__ . '/../vendor/autoload.php';

$configuratorCredentials = new ConfiguratorCredentials('http://192.168.1.60:3218', 'admin', 'gege22');

$hassio = new Hassio(null, $configuratorCredentials);

$fileContent = "put your content here";

var_dump($hassio->saveConfigFile('automations.yaml', $fileContent));