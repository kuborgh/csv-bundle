<?php

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;
use Kuborgh\CsvBundle\Parser\ParserInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Kuborgh\CsvBundle\Parser\Parser;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Test parser
 */
abstract class AbstractParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    protected function setUp()
    {
        $this->setConfiguration();
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
        $this->parser = $this->newParser($configObj);
    }

    /**
     * Instanciate a new parser with the given config
     *
     * @param ParserConfiguration $config
     *
     * @return ParserInterface
     */
    abstract protected function newParser(ParserConfiguration $config);
}
