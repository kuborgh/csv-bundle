<?php

namespace Kuborgh\CsvBundle\Parser;

/**
 * Very very simple CSV Parser without escaping support
 */
class SimpleParser extends AbstractParser implements ParserInterface
{
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

        $lines = explode($lineEnding, $csvString);
        $rows = array();
        foreach ($lines as $line) {
            $row = explode($delimiter, $line);
            $rows[] = $row;
        }

        return $rows;
    }
}
