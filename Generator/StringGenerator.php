<?php

namespace Kuborgh\CsvBundle\Generator;

/**
 * Generates rfc4180 conform csv by concatenating strings
 */
class StringGenerator extends AbstractGenerator implements GeneratorInterface
{
    /**
     * Generate csv string from array
     *
     * @param array $array 2-dimensional array
     *
     * @return string CSV
     */
    public function generate(array $array)
    {
        $delim = $this->configuration->getDelimiter();
        $lineEnd = $this->configuration->getLineEnding();

        $rowNum = 0;
        $lines = array();
        foreach ($array as $row) {
            if (!is_array($row)) {
                throw new \InvalidArgumentException('Expecting a 2-dimensional array as value');
            }
            $newRow = array();
            foreach ($row as $field) {
                $rowNum++;
                $type = gettype($field);
                switch ($type) {
                    case 'integer':
                    case 'NULL':
                        break;
                    case 'float':
                    case 'double':
                        $field = sprintf('%0.15F', $field);
                        $field = preg_replace('/\.?0*$/', '', $field);

                        break;
                    case 'string':
                        if (!empty($field)) {
                            // Enclose and escape quotes
                            $field = '"'.str_replace('"', '""', $field).'"';
                        }
                        break;
                    default:
                        throw new \InvalidArgumentException(sprintf('Unsupported field %s in array row %d', $type, $rowNum));
                }
                $newRow[] = $field;
            }
            $lines[] = implode($delim, $newRow);
        }
        $string = implode($lineEnd, $lines);

        return $string;
    }
}
