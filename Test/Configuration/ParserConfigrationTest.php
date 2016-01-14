<?php

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;

/**
 * Test parser configuration
 */
class ParserConfigurationTest extends AbstractConfigurationTest
{
    protected function setUp()
    {
        $this->configration = new ParserConfiguration();
    }
}
