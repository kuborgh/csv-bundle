<?php

namespace Kuborgh\CsvBundle\Parser;

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;

/**
 * Interface for all parsers
 */
interface ParserInterface
{
    /**
     * Parser constructor must consume the parser configuration
     *
     * @param ParserConfiguration $configuration
     */
    public function __construct(ParserConfiguration $configuration);

    /**
     * Parse the given string into an php array
     *
     * @param string $csvString
     *
     * @return array
     */
    public function parse($csvString): array;
}
