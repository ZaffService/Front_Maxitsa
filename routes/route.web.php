<?php
return [
    '/' => [
        'controller' => \App\Controllers\SecurityController::class,
        'action' => 'login'
    ],
    'login' => [
        'controller' => \App\Controllers\SecurityController::class,
        'action' => 'login'
    ],
    'register' => [
        'controller' => \App\Controllers\SecurityController::class,
        'action' => 'register'
    ],
    'client/dashboard' => [
        'controller' => \App\Controllers\UserController::class,
        'action' => 'index',
        'middleware' => ['auth']
    ],
    'user/depot' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'depot',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET', 'POST'],
    ],
    'user/transactions/' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'transactions',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET'],
    ],
    'user/transactions' => [
        'controller' => \App\Controllers\UserController::class,
        'action' => 'transactions',
        'middleware' => ['auth'],
        'methods' => ['GET'],
    ],
    'logout' => [
        'controller' => App\Controllers\SecurityController::class,
        'action' => 'logout',
        'middleware' => ['auth'],
        'methods' => ['GET'],
    ],
    'client/accountsList'=> [
        'controller' => \App\Controllers\UserController::class,
        'action' => 'accountsList',
    ],
    'client/create-account' => [
        'controller' => \App\Controllers\UserController::class,
        'action' => 'createSecondaryAccount',
    ],
    'client/set-main-account' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'setMainAccount',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['POST'],
    ],
    'client/depot-transfert' => [
        'controller' => App\Controllers\UserController::class,
        'action' => 'depotTransfert',
    ],
    'client/achat-woyafal' => [
        'controller' => \App\Controllers\UserController::class,
        'action' => 'achatWoyafal',
    ],
    'client/depot' => [
        'controller' => \App\Controllers\UserController::class,
        'action' => 'depot',
        'middleware' => ['auth'],
        'methods' => ['GET', 'POST'],
    ],
    'client/acountsList' => [
        'controller' => \App\Controllers\UserController::class,
        'action' => 'acountsList',
        'middleware' => ['auth'],
        'methods' => ['GET'],
    ],
];
