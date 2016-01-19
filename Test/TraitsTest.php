<?php

use Kuborgh\CsvBundle\DependencyInjection\KuborghCsvExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Kuborgh\CsvBundle\Parser\Parser;

/**
 * Test DI traits
 */
class TraitsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    public function testCsvGeneratorTrait()
    {
        $config = new \Kuborgh\CsvBundle\Configuration\GeneratorConfiguration();
        $generator = new \Kuborgh\CsvBundle\Generator\PhpGenerator($config);
        /** @var \Kuborgh\CsvBundle\Traits\CsvGeneratorTrait $obj */
        $obj = $this->getObjectForTrait('Kuborgh\CsvBundle\Traits\CsvGeneratorTrait');
        $obj->setCsvGenerator($generator);

        $class = new ReflectionClass(get_class($obj));
        $reflMethod = $class->getMethod('generateCsv');
        $reflMethod->setAccessible(true);
        $csv = $reflMethod->invoke($obj, array(array('a', 7)));

        $this->assertEquals("a,7\n", $csv);
    }

    /**
     * @expectedException \Exception
     */
    public function testGeneratorNotInjectedException()
    {
        $obj = $this->getObjectForTrait('Kuborgh\CsvBundle\Traits\CsvGeneratorTrait');

        $class = new ReflectionClass(get_class($obj));
        $reflMethod = $class->getMethod('generateCsv');
        $reflMethod->setAccessible(true);
        $reflMethod->invoke($obj, array(array('a', 7)));
    }

    public function testCsvParserTrait()
    {
        $config = new \Kuborgh\CsvBundle\Configuration\ParserConfiguration();
        $parser = new \Kuborgh\CsvBundle\Parser\SimpleParser($config);
        /** @var \Kuborgh\CsvBundle\Traits\CsvParserTrait $obj */
        $obj = $this->getObjectForTrait('Kuborgh\CsvBundle\Traits\CsvParserTrait');
        $obj->setCsvParser($parser);

        $class = new ReflectionClass(get_class($obj));
        $reflMethod = $class->getMethod('parseCsv');
        $reflMethod->setAccessible(true);
        $array = $reflMethod->invoke($obj, 'a,7');

        $this->assertEquals(array(array('a', 7)), $array);
    }

    /**
     * @expectedException \Exception
     */
    public function testParserNotInjectedException()
    {
        $obj = $this->getObjectForTrait('Kuborgh\CsvBundle\Traits\CsvParserTrait');

        $class = new ReflectionClass(get_class($obj));
        $reflMethod = $class->getMethod('parseCsv');
        $reflMethod->setAccessible(true);
        $reflMethod->invoke($obj, 'a,7');
    }

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new KuborghCsvExtension();
    }
}
