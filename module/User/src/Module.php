<?php

namespace User;

use Laminas\Db\Adapter\Adapter;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use User\Model\Table\UsersTable;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig(): array
    {
        return [
            'factories' => [
                UsersTable::class => function($sm) {
                    $dbAdapter = $sm->get(Adapter::class);
                    return new UsersTable($dbAdapter);
                },
            ]
        ];
    }
}