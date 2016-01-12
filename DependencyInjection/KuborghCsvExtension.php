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
            $parserConfigDef = new Definition('Kuborgh\CsvBundle\Configuration\ParserConfiguration');
            if ($parserConfig['delimiter']) {
                $parserConfigDef->addMethodCall('setDelimiter', [$parserConfig['delimiter']]);
            }
            $serviceDef = new Definition('Kuborgh\CsvBundle\Parser\Parser', [$parserConfigDef]);
            $serviceName = 'kuborgh_csv.importer.'.$parserName;
            $container->setDefinition($serviceName, $serviceDef);
        }
    }
}
