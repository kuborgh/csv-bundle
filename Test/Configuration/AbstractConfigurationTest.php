<?php

use Kuborgh\CsvBundle\Configuration\AbstractConfiguration;
use Kuborgh\CsvBundle\Exception\InvalidConfigurationException;
use PHPUnit\Framework\TestCase;

/**
 * Abstract test for abstract configuration
 */
abstract class AbstractConfigurationTest extends TestCase
{
    /**
     * @var AbstractConfiguration
     */
    protected $configuration;

    /**
     * @throws InvalidConfigurationException
     */
    public function testDelimiter(): void
    {
        $this->assertEquals(',', $this->configuration->getDelimiter());
        $this->configuration->setDelimiter(';');
        $this->assertEquals(';', $this->configuration->getDelimiter());
    }

    /**
     * @throws InvalidConfigurationException
     */
    public function testInvalidDelimiter(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        
        $this->configuration->setDelimiter('\/');
    }

    /**
     * @throws InvalidConfigurationException
     */
    public function testLineEnding(): void
    {
        $this->assertEquals("\r\n", $this->configuration->getLineEnding());
        $this->configuration->setLineEnding("\n");
        $this->assertEquals("\n", $this->configuration->getLineEnding());
        $this->configuration->setLineEnding("\r");
        $this->assertEquals("\r", $this->configuration->getLineEnding());
    }

    /**
     * @throws InvalidConfigurationException
     */
    public function testInvalidLineEnding(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        
        $this->configuration->setLineEnding('+');
    }
}
