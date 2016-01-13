<?php

namespace Kuborgh\CsvBundle\Parser;

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;

/**
 * Commons for all parsers
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * @var ParserConfiguration
     */
    protected $configuration;

    /**
     * Parser constructor.
     *
     * @param ParserConfiguration $configuration
     */
    public function __construct(ParserConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }
}
