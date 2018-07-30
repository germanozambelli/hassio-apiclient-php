<?php


use GermanoZambelli\Hassio\Credentials\ApiCredentials;
use GermanoZambelli\Hassio\Hassio;

include __DIR__ . '/../vendor/autoload.php';

$apiCredentials = new ApiCredentials('http://192.168.1.60:8123', 'gege22');

$hassio = new Hassio($apiCredentials);

var_dump($hassio->validationConfigFiles());