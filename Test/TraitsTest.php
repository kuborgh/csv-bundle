<?php

use Kuborgh\CsvBundle\Configuration\GeneratorConfiguration;
use Kuborgh\CsvBundle\Configuration\ParserConfiguration;
use Kuborgh\CsvBundle\DependencyInjection\KuborghCsvExtension;
use Kuborgh\CsvBundle\Generator\PhpGenerator;
use Kuborgh\CsvBundle\Parser\SimpleParser;
use Kuborgh\CsvBundle\Traits\CsvGeneratorTrait;
use Kuborgh\CsvBundle\Traits\CsvParserTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Test DI traits
 */
class TraitsTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var KuborghCsvExtension
     */
    private $extension;

    public function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new KuborghCsvExtension();
    }
    /**
     * @throws ReflectionException
     */
    public function testCsvGeneratorTrait(): void
    {
        $config = new GeneratorConfiguration();
        $generator = new PhpGenerator($config);

        /** @var CsvGeneratorTrait $obj */
        $obj = $this->getObjectForTrait(CsvGeneratorTrait::class);
        $obj->setCsvGenerator($generator);

        $class = new ReflectionClass(get_class($obj));
        $reflMethod = $class->getMethod('generateCsv');
        $reflMethod->setAccessible(true);
        $csv = $reflMethod->invoke($obj, array(array('a', 7)));

        $this->assertEquals("a,7\n", $csv);
    }

    /**
     * @throws ReflectionException
     */
    public function testGeneratorNotInjectedException(): void
    {
        $this->expectException(RuntimeException::class);

        $obj = $this->getObjectForTrait(CsvGeneratorTrait::class);

        $class = new ReflectionClass(get_class($obj));
        $reflMethod = $class->getMethod('generateCsv');
        $reflMethod->setAccessible(true);
        $reflMethod->invoke($obj, array(array('a', 7)));
    }

    /**
     * @throws ReflectionException
     */
    public function testCsvParserTrait(): void
    {
        $config = new ParserConfiguration();
        $parser = new SimpleParser($config);

        /** @var CsvParserTrait $obj */
        $obj = $this->getObjectForTrait(CsvParserTrait::class);
        $obj->setCsvParser($parser);

        $class = new ReflectionClass(get_class($obj));
        $reflMethod = $class->getMethod('parseCsv');
        $reflMethod->setAccessible(true);
        $array = $reflMethod->invoke($obj, 'a,7');

        $this->assertEquals(array(array('a', 7)), $array);
    }

    /**
     * @throws ReflectionException
     */
    public function testParserNotInjectedException(): void
    {
        $this->expectException(Exception::class);

        $obj = $this->getObjectForTrait(CsvParserTrait::class);

        $class = new ReflectionClass(get_class($obj));
        $reflMethod = $class->getMethod('parseCsv');
        $reflMethod->setAccessible(true);
        $reflMethod->invoke($obj, 'a,7');
    }
}
