<?php

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;
use Kuborgh\CsvBundle\DependencyInjection\KuborghCsvExtension;
use Kuborgh\CsvBundle\Generator\GeneratorInterface;
use Kuborgh\CsvBundle\Generator\PhpGenerator;
use Kuborgh\CsvBundle\Parser\ParserInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Test symfony configuration
 */
class DependencyInjectionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var KuborghCsvExtension
     */
    protected $extension;

    public function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new KuborghCsvExtension();
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testDefaultParserConfiguration(): void
    {
        $config = array('kuborgh_csv' => array('parser' => array('test' => array())));
        $this->extension->load($config, $this->container);

        /** @var ParserInterface $testParser */
        $testParser = $this->container->get('kuborgh_csv.parser.test');

        $class = new ReflectionClass(get_class($testParser));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        /** @var ParserConfiguration $config */
        $config = $reflCconfig->getValue($testParser);

        $this->assertEquals(',', $config->getDelimiter());
        $this->assertEquals("\r\n", $config->getLineEnding());
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testParserConfiguration(): void
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

        /** @var ParserInterface $testParser */
        $testParser = $this->container->get('kuborgh_csv.parser.test');

        $class = new ReflectionClass(get_class($testParser));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        $config = $reflCconfig->getValue($testParser);

        $this->assertEquals('7', $config->getDelimiter());
        $this->assertEquals("\n", $config->getLineEnding());
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testDefaultGeneratorConfiguration(): void
    {
        $config = array('kuborgh_csv' => array('generator' => array('test' => array())));
        $this->extension->load($config, $this->container);

        /** @var GeneratorInterface $testGenerator */
        $testGenerator = $this->container->get('kuborgh_csv.generator.test');

        $class = new ReflectionClass(get_class($testGenerator));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        /** @var ParserConfiguration $config */
        $config = $reflCconfig->getValue($testGenerator);

        $this->assertEquals(',', $config->getDelimiter());
        $this->assertEquals("\r\n", $config->getLineEnding());
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testGeneratorConfiguration(): void
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

        /** @var PhpGenerator $testGenerator */
        $testGenerator = $this->container->get('kuborgh_csv.generator.test');

        $class = new ReflectionClass(get_class($testGenerator));
        $reflCconfig = $class->getProperty('configuration');
        $reflCconfig->setAccessible(true);
        $config = $reflCconfig->getValue($testGenerator);

        $this->assertEquals('7', $config->getDelimiter());
        $this->assertEquals("\n", $config->getLineEnding());
    }
}
