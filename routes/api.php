<?php

declare(strict_types=1);

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add('purchase', new Route('/purchase', ['_controller' => [new App\Controllers\PurchaseController(), 'index']], methods: ['POST']));
$routes->add('refund', new Route('/refund',  ['_controller' => [new App\Controllers\RefundController(), 'index']], methods: ['POST']));
$routes->add('payout', new Route('/payout',  ['_controller' => [new App\Controllers\PayoutController(), 'index']], methods: ['POST']));

return $routes;
