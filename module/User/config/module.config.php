<?php

namespace User;

use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => Factory\AuthControllerFactory::class,
            Controller\LoginController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'signup' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/auth',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'create',
                    ],
                ],
            ],
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'auth/create'   => __DIR__ . '/../view/user/auth/create.phtml',
            'login/index'   => __DIR__ . '/../view/user/auth/login.phtml',
            'password/forgot' => __DIR__ . '/../view/user/auth/forgot.phtml',
            'password/reset' => __DIR__ . '/../view/user/auth/reset.phtml',
            'profile/index' => __DIR__ . '/../view/user/profile/index.phtml',
        ],
        'template_path_stack' => [
            'user' => __DIR__ . '/../view',
        ],
    ],
];
