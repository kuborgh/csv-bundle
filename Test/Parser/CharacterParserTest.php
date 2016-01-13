<?php

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;
use Kuborgh\CsvBundle\Parser\CharacterParser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Test parser
 */
class CharacterParserTest extends AbstractParserTest
{
    public function testSimpleParsing()
    {
        $csv = <<<EOT
a,b,c\r\nd,e,f
EOT;
        $array = $this->parser->parse($csv);

        $this->assertNumRows(2, $array);
        $this->assertNumCols(3, $array);
        $this->assertEquals('a', $array[0][0]);
        $this->assertEquals('b', $array[0][1]);
        $this->assertEquals('c', $array[0][2]);
        $this->assertEquals('d', $array[1][0]);
        $this->assertEquals('e', $array[1][1]);
        $this->assertEquals('f', $array[1][2]);
    }

    public function testConfiguredParsing()
    {
        $config = array(
            'delimiter'   => ';',
            'line_ending' => "\n",
        );
        $this->setConfiguration($config);
        $csv = <<<EOT
a;b;c
d;e;f
EOT;
        $array = $this->parser->parse($csv);

        $this->assertNumRows(2, $array);
        $this->assertNumCols(3, $array);
        $this->assertEquals('a', $array[0][0]);
        $this->assertEquals('b', $array[0][1]);
        $this->assertEquals('c', $array[0][2]);
        $this->assertEquals('d', $array[1][0]);
        $this->assertEquals('e', $array[1][1]);
        $this->assertEquals('f', $array[1][2]);
    }

    public function testEscaping()
    {
        $config = array(
            'delimiter'   => ';',
            'line_ending' => "\n",
        );
        $this->setConfiguration($config);
        $csv = file_get_contents(__DIR__.'/../Mock/Escaping.csv');
        $array = $this->parser->parse($csv);

        $this->assertNumRows(2, $array);
        $this->assertNumCols(5, $array);

        // Row 1
        $this->assertEquals('For linebreaks only \n (LF) is used', $array[0][0]);
        $this->assertEquals('It has 5 rows per line', $array[0][1]);
        $this->assertEquals('Delimiter is ;', $array[0][2]);
        $this->assertEquals('File ends with an empty row', $array[0][3]);
        $this->assertEquals('Row 5', $array[0][4]);

        $this->assertEquals('Second line', $array[1][0]);
        $this->assertEquals('"', $array[1][1]);
        $this->assertEquals('Previously was only a double quote', $array[1][2]);
        $this->assertEquals("This file also contains\nline breaks and \"inline quotes\" inside fields", $array[1][3]);
        $this->assertEquals(7, $array[1][4]);
    }

    public function testQuotes()
    {
        $config = array(
            'delimiter'   => ';',
            'line_ending' => "\n",
        );
        $this->setConfiguration($config);
        $csv = <<<EOT
";";"";""""
"
";;""""""
EOT;
        $array = $this->parser->parse($csv);

        $this->assertNumRows(2, $array);
        $this->assertNumCols(3, $array);
        $this->assertEquals(';', $array[0][0]);
        $this->assertEquals('', $array[0][1]);
        $this->assertEquals('"', $array[0][2]);
        $this->assertEquals("\n", $array[1][0]);
        $this->assertEquals('', $array[1][1]);
        $this->assertEquals('""', $array[1][2]);
    }

    /**
     * Instanciate a new parser with the given config
     *
     * @param ParserConfiguration $config
     *
     * @return \Kuborgh\CsvBundle\Parser\ParserInterface
     */
    protected function newParser(ParserConfiguration $config)
    {
        return new CharacterParser($config);
    }
}
