<?php

use Kuborgh\CsvBundle\Configuration\AbstractConfiguration;

/**
 * Abstract test for abstract configuration
 */
abstract class AbstractConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractConfiguration
     */
    protected $configration;

    public function testDelimiter()
    {
        $this->assertEquals(',', $this->configration->getDelimiter());
        $this->configration->setDelimiter(';');
        $this->assertEquals(';', $this->configration->getDelimiter());
    }

    /**
     * @expectedException \Kuborgh\CsvBundle\Exception\InvalidConfigurationException
     */
    public function testInvalidDelimiter()
    {
        $this->configration->setDelimiter('\/');
    }

    public function testLineEnding()
    {
        $this->assertEquals("\r\n", $this->configration->getLineEnding());
        $this->configration->setLineEnding("\n");
        $this->assertEquals("\n", $this->configration->getLineEnding());
        $this->configration->setLineEnding("\r");
        $this->assertEquals("\r", $this->configration->getLineEnding());
    }

    /**
     * @expectedException \Kuborgh\CsvBundle\Exception\InvalidConfigurationException
     */
    public function testInvalidLineEnding()
    {
        $this->configration->setLineEnding('+');
    }
}
