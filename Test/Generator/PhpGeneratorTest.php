<?php

use Kuborgh\CsvBundle\Configuration\GeneratorConfiguration;
use Kuborgh\CsvBundle\Generator\GeneratorInterface;
use Kuborgh\CsvBundle\Generator\PhpGenerator;

/**
 * Test generator
 */
class PhpGeneratorTest extends AbstractGeneratorTest
{
    public function testSimpleCsv(): void
    {
        $array = array(
            array('a', 'b', 1),
            array('c', 'hallo', 'welt'),
        );
        $csv = $this->generator->generate($array);
        $this->assertEquals("a,b,1\nc,hallo,welt\n", $csv);
    }

    public function testOtherDelimiter(): void
    {
        $this->setConfiguration(array('delimiter' => ';'));
        $array = array(
            array('a', 'b', 1),
            array('c', 'hallo', 'welt'),
        );
        $csv = $this->generator->generate($array);
        $this->assertEquals("a;b;1\nc;hallo;welt\n", $csv);
    }

    public function testInvalidData(): array
    {
        $this->expectException(InvalidArgumentException::class);

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
    protected function newGenerator(GeneratorConfiguration $config): GeneratorInterface
    {
        return new PhpGenerator($config);
    }
}
