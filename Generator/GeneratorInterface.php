<?php

namespace Kuborgh\CsvBundle\Generator;

use Kuborgh\CsvBundle\Configuration\GeneratorConfiguration;

/**
 * Interface for all generators
 */
interface GeneratorInterface
{
    /**
     * Constructor must consume the configuration
     *
     * @param GeneratorConfiguration $configuration
     */
    public function __construct(GeneratorConfiguration $configuration);

    /**
     * Generate csv string from array
     *
     * @param array $array 2-dimensional array
     *
     * @return string CSV
     */
    public function generate(array $array): string;
}
