<?php

namespace Kuborgh\CsvBundle\Generator;

use Kuborgh\CsvBundle\Configuration\GeneratorConfiguration;

/**
 * Commons for all generators
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * @var GeneratorConfiguration
     */
    protected $configuration;

    /**
     * Parser constructor.
     *
     * @param GeneratorConfiguration $configuration
     */
    public function __construct(GeneratorConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }
}
