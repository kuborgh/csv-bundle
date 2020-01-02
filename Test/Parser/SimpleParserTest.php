<?php

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;
use Kuborgh\CsvBundle\Parser\ParserInterface;
use Kuborgh\CsvBundle\Parser\SimpleParser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Test parser
 */
class SimpleParserTest extends AbstractParserTest
{
    public function testSimpleParsing(): void
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

    public function testConfiguredParsing(): void
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

    /**
     * @param ParserConfiguration $config
     *
     * @return ParserInterface
     */
    protected function newParser(ParserConfiguration $config): ParserInterface
    {
        return new SimpleParser($config);
    }
}
