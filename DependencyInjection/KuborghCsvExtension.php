<?php
/*
 * (c) Kuborgh GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kuborgh\CsvBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class KuborghCsvExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Load parameters
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('parameters.yml');

        $this->loadParserConfig($config['parser'], $container);
    }

    /**
     * Load configurations for csv parsers
     *
     * @param array            $config    Config
     * @param ContainerBuilder $container Container
     */
    protected function loadParserConfig(array $config, ContainerBuilder $container)
    {
        foreach ($config as $parserName => $parserConfig) {
            $parserConfigClass = $container->getParameter('kuborgh_csv.configuration.parser.class');
            $parserConfigDef = new Definition($parserConfigClass);

            // Apply config
            if ($parserConfig['delimiter']) {
                $parserConfigDef->addMethodCall('setDelimiter', [$parserConfig['delimiter']]);
            }
            if ($parserConfig['line_ending']) {
                $parserConfigDef->addMethodCall('setLineEnding', [$parserConfig['line_ending']]);
            }

            $parserClass = $container->getParameter('kuborgh_csv.parser.class');
            $serviceDef = new Definition($parserClass, [$parserConfigDef]);
            $serviceName = 'kuborgh_csv.importer.'.$parserName;
            $container->setDefinition($serviceName, $serviceDef);
        }
    }
}
