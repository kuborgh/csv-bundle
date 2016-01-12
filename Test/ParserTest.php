<?php

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Kuborgh\CsvBundle\Parser\Parser;
use Symfony\Component\PropertyAccess\PropertyAccess;

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

    /**
     * @param int   $num
     * @param array $array
     */
    protected function assertNumRows($num, $array)
    {
        $cnt = count($array);
        $errMsg = sprintf('Number of rows differs. Found %d but expected %d', $cnt, $num);
        $this->assertEquals($num, $cnt, $errMsg);
    }

    /**
     * @param int   $num
     * @param array $array
     */
    protected function assertNumCols($num, $array)
    {
        $rowNum = 0;
        foreach ($array as $row) {
            $cnt = count($row);
            $errMsg = sprintf('Number of columns differs in row %d. Found %d but expected %d', $rowNum, $cnt, $num);
            $this->assertEquals($num, $cnt, $errMsg);
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
        // apply attributes
        $configObj = new ParserConfiguration();
        $acc = PropertyAccess::createPropertyAccessor();
        foreach ($config as $key => $val) {
            $acc->setValue($configObj, $key, $val);
        }

        // Update parser
        $this->parser = new Parser($configObj);
    }

    protected function setUp()
    {
        $this->setConfiguration();
    }
}
