<?php

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;
use Kuborgh\CsvBundle\DependencyInjection\KuborghCsvExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Kuborgh\CsvBundle\Parser\Parser;

/**
 * Test parser
 */
class ParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Parser
     */
    protected $parser;

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

    /**
     * @param int   $num
     * @param array $array
     */
    protected function assertNumRows($num, $array)
    {
        $this->assertEquals($num, count($array), 'Number of rows differs. ');
    }

    /**
     * @param int   $num
     * @param array $array
     */
    protected function assertNumCols($num, $array)
    {
        $rowNum = 0;
        foreach ($array as $row) {
            $this->assertEquals($num, count($row), 'Number of columns differs in row '.$rowNum);
            $rowNum++;
        }
    }

    /**
     * Apply configuration
     *
     * @param array $config
     */
    protected function setConfiguration(array $config = array())
    {
        // @todo apply attributes
        $config = new ParserConfiguration();
        $this->parser = new Parser($config);
    }

    protected function setUp()
    {
        $this->setConfiguration();
    }
}
