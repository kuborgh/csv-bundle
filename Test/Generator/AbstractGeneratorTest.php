<?php

use Kuborgh\CsvBundle\Configuration\GeneratorConfiguration;
use Kuborgh\CsvBundle\Generator\GeneratorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Test generator
 */
abstract class AbstractGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var GeneratorInterface
     */
    protected $generator;

    protected function setUp()
    {
        $this->setConfiguration();
    }

    /**
     * Apply configuration
     *
     * @param array $config
     */
    protected function setConfiguration(array $config = array())
    {
        // apply attributes
        $configObj = new GeneratorConfiguration();
        $acc = PropertyAccess::createPropertyAccessor();
        foreach ($config as $key => $val) {
            $acc->setValue($configObj, $key, $val);
        }

        // Update parser
        $this->generator = $this->newGenerator($configObj);
    }

    /**
     * Instanciate a new parser with the given config
     *
     * @param GeneratorConfiguration $config
     *
     * @return GeneratorInterface
     */
    abstract protected function newGenerator(GeneratorConfiguration $config);
}
