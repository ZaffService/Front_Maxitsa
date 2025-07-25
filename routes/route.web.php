<?php
return [
    'user/depot' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'depot',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET', 'POST'],
    ],
    '/' => [
        'controller' => App\Controllers\SecurityController::class,
        'method' => 'login',
        'middleware' => [],  // ← Changé en SINGULIER
        'methods' => ['GET', 'POST'],
    ],
    'client/dashboard' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'index',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET'],
    ],
    'user/transactions/' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'transactions',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET'],
    ],
    'logout' => [
        'controller' => App\Controllers\SecurityController::class,
        'method' => 'logout',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET'],
    ],
    'register' => [
        'controller' => App\Controllers\SecurityController::class,
        'method' => 'register',
        'middleware' => ['crypt_password'],  // ← Changé en SINGULIER
        'methods' => ['GET', 'POST'],
    ],
    '/client/acountsList'=> [
        'controller' => App\Controllers\UserController::class,
        'method' => 'acountsList',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET'],
    ],
    '/client/create-account'=> [
        'controller' => App\Controllers\UserController::class,
        'method' => 'createSecondaryAccount',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET', 'POST'],
        
    ],
    '/client/set-main-account' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'setMainAccount',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['POST'],
    ],
    'client/depot-transfert' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'depotTransfert',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET', 'POST'],
    ],
];
