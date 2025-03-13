<?php

namespace LinkORB\Bundle\SpicedbBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class LinkORBSpicedbBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->addCompilerPass(DoctrineOrmMappingsPass::createAttributeMappingDriver(
            ['LinkORB\Bundle\SpicedbBundle\Entity'],
            [__DIR__.DIRECTORY_SEPARATOR.'Entity']
        ));
    }

    public function loadExtension(
        array $config,
        ContainerConfigurator $container,
        ContainerBuilder $builder,
    ): void {
        $container->import('../config/services.yaml');
    }
}
