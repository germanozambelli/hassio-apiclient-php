<?php

use GermanoZambelli\Hassio\Credentials\ConfiguratorCredentials;
use GermanoZambelli\Hassio\Hassio;

include __DIR__ . '/../vendor/autoload.php';

$configuratorCredentials = new ConfiguratorCredentials('http://ipaddress:port', 'username', 'password');

$hassio = new Hassio(null, $configuratorCredentials);

var_dump($hassio->getConfigFile('automations.yaml'));