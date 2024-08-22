<?php

namespace App\Infrastructure\DI;

use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Config\Definition\Processor;

class AppExtension  implements ExtensionInterface
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration(false);
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);


        dd($config);
//        dd($container);
        // TODO: Implement load() method.
    }

    public function getNamespace()
    {
        // TODO: Implement getNamespace() method.
    }

    public function getXsdValidationBasePath()
    {
        // TODO: Implement getXsdValidationBasePath() method.
    }

    public function getAlias()
    {
        return 'app';
        // TODO: Implement getAlias() method.
    }
}