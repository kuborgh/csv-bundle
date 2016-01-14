<?php

use Kuborgh\CsvBundle\Configuration\GeneratorConfiguration;
use Kuborgh\CsvBundle\Generator\GeneratorInterface;
use Kuborgh\CsvBundle\Generator\PhpGenerator;

/**
 * Test generator
 */
class PhpGeneratorTest extends AbstractGeneratorTest
{
    public function testSimpleCsv()
    {
        $array = array(
            array('a', 'b', 1),
            array('c', 'hallo', 'welt'),
        );
        $csv = $this->generator->generate($array);
        $this->assertEquals("a,b,1\nc,hallo,welt\n", $csv);
    }

    public function testOtherDelimiter()
    {
        $this->setConfiguration(array('delimiter' => ';'));
        $array = array(
            array('a', 'b', 1),
            array('c', 'hallo', 'welt'),
        );
        $csv = $this->generator->generate($array);
        $this->assertEquals("a;b;1\nc;hallo;welt\n", $csv);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidData()
    {
        $array = array(7);
        $this->generator->generate($array);
    }

    /**
     * Instanciate a new parser with the given config
     *
     * @param GeneratorConfiguration $config
     *
     * @return GeneratorInterface
     */
    protected function newGenerator(GeneratorConfiguration $config)
    {
        return new PhpGenerator($config);
    }
}
