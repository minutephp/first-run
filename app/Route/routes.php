<?php

/** @var Router $router */
use Minute\Routing\Router;

$router->get('/first-run', 'FirstRun', false);
$router->post('/first-run', 'FirstRun@setup', false);

$router->get('/first-run/complete', null, 'admin');
$router->post('/first-run/complete', 'FirstRun/Complete@update', 'admin');


$router->get('/first-run/apache', null, 'admin');

$router->post('/first-run/installer', null, 'admin')
       ->setDefault('_noView', true);