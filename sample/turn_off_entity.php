<?php

use GermanoZambelli\Hassio\Credentials\ApiCredentials;
use GermanoZambelli\Hassio\Hassio;
use GermanoZambelli\Hassio\Model\Entity;

include __DIR__ . '/../vendor/autoload.php';

$apiCredentials = new ApiCredentials('http://ipaddress:port', 'password');

$hassio = new Hassio($apiCredentials);

var_dump($hassio->turnOffEntity(new Entity('light','light.lampadario','Lampadario')));