<?php declare(strict_types=1);

namespace LinkORB\AuthzedBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('authzed');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('uri')
                    ->info('Define your SpiceDB URI here')
                    ->example('http://spicedb:8443')
                    ->isRequired()
                ->end()
                ->scalarNode('key')
                    ->info('Pass your SpiceDB API key here')
                    ->example('somerandomkeyhere')
                    ->isRequired()
                ->end()
                ->arrayNode('permissions')
                    ->useAttributeAsKey('objectType')
                        ->arrayPrototype()
                            ->requiresAtLeastOneElement()
                            ->beforeNormalization()->castToArray()->end()
                            ->scalarPrototype()->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
