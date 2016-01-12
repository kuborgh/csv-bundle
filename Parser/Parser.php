<?php

namespace Kuborgh\CsvBundle\Parser;

use Kuborgh\CsvBundle\Configuration\ParserConfiguration;

/**
 * CSV Parser
 */
class Parser
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

    /**
     * Parse the given string into an php array
     *
     * @param string $csvString
     *
     * @return array
     */
    public function parse($csvString)
    {
        $lineEnding = $this->configuration->getLineEnding();
        $delimiter = $this->configuration->getDelimiter();

        // @todo very simple implementation. Improve and/or implement strategy pattern
        $lines = explode($lineEnding, $csvString);
        $rows = array();
        foreach ($lines as $line) {
            $row = explode($delimiter, $line);
            $rows[] = $row;
        }

        return $rows;
    }
}
