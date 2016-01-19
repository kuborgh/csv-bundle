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

        /** @var \Kuborgh\CsvBundle\Parser\ParserInterface $testParser */
        $testParser = $this->container->get('kuborgh_csv.parser.test');

        $class = new ReflectionClass(get_class($testParser));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        /** @var \Kuborgh\CsvBundle\Configuration\ParserConfiguration $config */
        $config = $reflCconfig->getValue($testParser);

        $this->assertEquals(',', $config->getDelimiter());
        $this->assertEquals("\r\n", $config->getLineEnding());
    }

    public function testParserConfiguration()
    {
        $config = array(
            'kuborgh_csv' => array(
                'parser' => array(
                    'test' => array(
                        'implementation' => 'character',
                        'delimiter'      => '7',
                        'line_ending'    => "\n",
                    ),
                ),
            ),
        );
        $this->extension->load($config, $this->container);

        /** @var \Kuborgh\CsvBundle\Parser\ParserInterface $testParser */
        $testParser = $this->container->get('kuborgh_csv.parser.test');

        $class = new ReflectionClass(get_class($testParser));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        $config = $reflCconfig->getValue($testParser);

        $this->assertEquals('7', $config->getDelimiter());
        $this->assertEquals("\n", $config->getLineEnding());
    }

    public function testDefaultGeneratorConfiguration()
    {
        $config = array('kuborgh_csv' => array('generator' => array('test' => array())));
        $this->extension->load($config, $this->container);

        /** @var \Kuborgh\CsvBundle\Generator\GeneratorInterface $testGenerator */
        $testGenerator = $this->container->get('kuborgh_csv.generator.test');

        $class = new ReflectionClass(get_class($testGenerator));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        /** @var \Kuborgh\CsvBundle\Configuration\ParserConfiguration $config */
        $config = $reflCconfig->getValue($testGenerator);

        $this->assertEquals(',', $config->getDelimiter());
        $this->assertEquals("\r\n", $config->getLineEnding());
    }

    public function testGeneratorConfiguration()
    {
        $config = array(
            'kuborgh_csv' => array(
                'generator' => array(
                    'test' => array(
                        'implementation' => 'php',
                        'delimiter'      => '7',
                        'line_ending'    => "\n",
                    ),
                ),
            ),
        );
        $this->extension->load($config, $this->container);

        /** @var \Kuborgh\CsvBundle\Generator\PhpGenerator $testGenerator */
        $testGenerator = $this->container->get('kuborgh_csv.generator.test');

        $class = new ReflectionClass(get_class($testGenerator));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        $config = $reflCconfig->getValue($testGenerator);

        $this->assertEquals('7', $config->getDelimiter());
        $this->assertEquals("\n", $config->getLineEnding());
    }

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new KuborghCsvExtension();
    }
}
