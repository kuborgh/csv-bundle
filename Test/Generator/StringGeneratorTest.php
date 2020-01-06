<?php

use Kuborgh\CsvBundle\Configuration\GeneratorConfiguration;
use Kuborgh\CsvBundle\Generator\GeneratorInterface;
use Kuborgh\CsvBundle\Generator\StringGenerator;

/**
 * Test generator
 */
class StringGeneratorTest extends AbstractGeneratorTest
{
    public function testQuotingAndTypesEscaping(): void
    {
        $array = array(
            array('Hello', '"World"', 7),
            array('', null, 0),
            array('Float"', '', '"'),
        );
        $csv = $this->generator->generate($array);
        $this->assertEquals("\"Hello\",\"\"\"World\"\"\",7\r\n,,0\r\n\"Float\"\"\",,\"\"\"\"", $csv);
    }

    public function testFloatDe(): void
    {
        $array = array(
            array(1.0, 1.2, 1.23456789012345),
            array((float) 122.0, 22.22, (float) 0.0),
        );
        setlocale(LC_NUMERIC, 'de_DE');
        $csv = $this->generator->generate($array);
        $this->assertEquals("1,1.2,1.23456789012345\r\n122,22.219999999999999,0", $csv);
    }

    public function testFloatEn(): void
    {
        $array = array(
            array(1.0, 1.2, 1.2345678901234),
        );
        setlocale(LC_NUMERIC, 'en_US');
        $csv = $this->generator->generate($array);
        $this->assertEquals("1,1.2,1.2345678901234", $csv);
    }


    public function testInvalidType1(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $array = array(
            array(array(1)),
        );
        $this->generator->generate($array);
    }

    public function testInvalidType2(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $array = array(
            array(new \stdClass()),
        );
        $this->generator->generate($array);
    }

    public function testInvalidStructure(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $array = array(1);
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
        return new StringGenerator($config);
    }
}
