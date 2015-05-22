<?php

// YOU TOKEN FOR SLACK
$token = '';

include __DIR__.'/vendor/autoload.php';

$console = new \Symfony\Component\Console\Application();

$console->add(new \AgentSIB\TestApp\TestCommand($token));

$console->run();


