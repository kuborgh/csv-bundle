<?php

namespace Kuborgh\CsvBundle\Traits;

use Exception;
use Kuborgh\CsvBundle\Parser\ParserInterface;
use RuntimeException;

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
    public function setCsvParser($csvParser): void
    {
        $this->csvParser = $csvParser;
    }

    /**
     * Get csvParser
     *
     * @return ParserInterface
     *
     * @throws Exception
     */
    protected function getCsvParser(): ParserInterface
    {
        if (null === $this->csvParser) {
            throw new RuntimeException('CSV Parser not injected into '.get_class($this));
        }

        return $this->csvParser;
    }

    /**
     * Convenience wrapper
     *
     * @param $csv
     *
     * @return array
     *
     * @throws Exception
     */
    protected function parseCsv($csv): array
    {
        return $this->getCsvParser()->parse($csv);
    }
}
