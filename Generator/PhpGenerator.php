<?php

namespace Kuborgh\CsvBundle\Generator;

use InvalidArgumentException;

/**
 * Generates CSV by means of native php function fputcsv()
 * This may not be conform to rfc4180.
 * Also the line ending is for example not configurable
 */
class PhpGenerator extends AbstractGenerator
{
    /**
     * Generate csv string from array
     *
     * @param array $array 2-dimensional array
     *
     * @return string CSV
     */
    public function generate(array $array): string
    {
        $buffer = fopen('php://temp', 'rb+');
        $delim = $this->configuration->getDelimiter();

        foreach ($array as $row) {
            if (!is_array($row)) {
                throw new InvalidArgumentException('Expecting a 2-dimensional array as value');
            }
            fputcsv($buffer, $row, $delim);
        }

        // Read CSV Buffer
        rewind($buffer);
        $csv = '';
        while (!feof($buffer)) {
            $csv .= fread($buffer, 8192);
        }
        fclose($buffer);

        return $csv;
    }
}
