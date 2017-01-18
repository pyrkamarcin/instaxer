<?php

require_once __DIR__ . '/../vendor/autoload.php';

$test = new \Instaxer\YamlLoader();

$dupa = $test->load('test.yml');
var_dump($test);