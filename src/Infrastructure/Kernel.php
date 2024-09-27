<?php

namespace App\Infrastructure;

use App\Complex\TestComplex;
use App\Handler\Handler1;
use App\Handler\Handler2;
use App\Handler\HandlerInterface;
use App\Infrastructure\DI\AppExtension;
use events\TestClass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel implements CompilerPassInterface
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        //        $container->registerExtension(new AppExtension());;
        //        $container->registerForAutoconfiguration(HandlerInterface::class)->addTag('test_tag');


        //        $deff = new Definition(Handler1::class);
        //        $container->setDefinition(Handler2::class,$deff);

        //        $container->getDefinitions()
        //        dd($container->getDefinitions());

        // //        $res = $container->has(Handler1::class);
        // //        dd($res);
        //        $services = $container->findTaggedServiceIds('test_tag');
        //        dd($services);
        //        foreach ($services as $serviceId => $tags) {
        //            dd($serviceId);
        //        }
        //        $testComplexDefinition = new Definition(TestComplex::class,[
        //            new Reference('logger')
        //        ]);
        //        $testComplexDefinition->addTag('def-tag');
        //        $container->set('complex.test',$testComplexDefinition);
        //        $definition = new Definition(TestClass::class);
        //        $container->set('test',$definition);
    }

    public function process(ContainerBuilder $container)
    {
        //        $res = $container->findTaggedServiceIds('test_tag');
        //        dd($res);
        // TODO: Implement process() method.
    }
}
