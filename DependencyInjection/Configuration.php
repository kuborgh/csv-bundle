<?php
/*
 * (c) Kuborgh GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kuborgh\CsvBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kuborgh_csv');

        $rootNode
            ->children()
                ->arrayNode('parser')
                    ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('delimiter')->defaultValue(',')->end()
                                ->scalarNode('line_ending')->defaultValue("\r\n")->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
