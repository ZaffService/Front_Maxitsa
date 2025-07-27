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
    'logout' => [
        'controller' => App\Controllers\SecurityController::class,
        'method' => 'logout',
        'middleware' => ['auth'],  // ← Changé en SINGULIER
        'methods' => ['GET'],
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
    'client/achat-woyafal' => [
        'controller' => \App\Controllers\UserController::class,
        'action' => 'achatWoyafal',
        'middleware' => ['auth'],
        'methods' => ['GET', 'POST'],
    ],
];
