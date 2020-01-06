<?php

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;

/**
 * Test parser configuration
 */
class ParserConfigurationTest extends AbstractConfigurationTest
{
    public function setUp(): void
    {
        $this->configuration = new ParserConfiguration();
    }
}
