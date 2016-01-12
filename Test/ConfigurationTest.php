<?php

use Kuborgh\CsvBundle\DependencyInjection\KuborghCsvExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Kuborgh\CsvBundle\Parser\Parser;

/**
 * Test symfony configuration
 */
class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var KuborghCsvExtension
     */
    protected $extension;

    public function testDefaultParserConfiguration()
    {
        $config = array('kuborgh_csv' => array('parser' => array('test' => array())));
        $this->extension->load($config, $this->container);

        /** @var \Kuborgh\CsvBundle\Parser\Parser $testParser */
        $testParser = $this->container->get('kuborgh_csv.importer.test');

        $class = new ReflectionClass(get_class($testParser));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        $config = $reflCconfig->getValue($testParser);

        $this->assertEquals(',', $config->getDelimiter());
    }

    public function testParserConfiguration()
    {
        $config = array(
            'kuborgh_csv' => array(
                'parser' => array(
                    'test' => array(
                        'delimiter' => '7',
                    ),
                ),
            ),
        );
        $this->extension->load($config, $this->container);

        /** @var \Kuborgh\CsvBundle\Parser\Parser $testParser */
        $testParser = $this->container->get('kuborgh_csv.importer.test');

        $class = new ReflectionClass(get_class($testParser));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        $config = $reflCconfig->getValue($testParser);

        $this->assertEquals('7', $config->getDelimiter());
    }

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new KuborghCsvExtension();
    }
}
