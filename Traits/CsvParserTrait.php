<?php

namespace Kuborgh\CsvBundle\Traits;

use Kuborgh\CsvBundle\Parser\ParserInterface;

/**
 * Helper for setter-injection of a csv parser
 */
trait CsvParserTrait
{
    /**
     * @var ParserInterface
     */
    private $csvParser;

    /**
     * Set csvParser
     *
     * @param ParserInterface $csvParser
     */
    public function setCsvParser($csvParser)
    {
        $this->csvParser = $csvParser;
    }

    /**
     * Get csvParser
     *
     * @return ParserInterface
     * @throws \Exception
     */
    protected function getCsvParser()
    {
        if (is_null($this->csvParser)) {
            throw new \Exception('CSV Parser not injected into '.get_class($this));
        }

        return $this->csvParser;
    }

    /**
     * Convenience wrapper
     *
     * @param string $csv
     *
     * @return array
     */
    protected function parseCsv($csv)
    {
        return $this->getCsvParser()->parse($csv);
    }
}
