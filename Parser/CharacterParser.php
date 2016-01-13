<?php

namespace Kuborgh\CsvBundle\Parser;

use Kuborgh\CsvBundle\Exception\EofException;

/**
 * Full-featured rfc4180 parser, but may be slow for large files.
 * The csv is parsed bytewise with lookahead
 */
class CharacterParser extends AbstractParser implements ParserInterface
{
    /**
     * Pointer to the next character being read
     *
     * @var int
     */
    protected $nextChar = 0;

    /**
     * Input string
     *
     * @var string
     */
    protected $csvString = '';

    /**
     * Length of the input string
     *
     * @var int
     */
    protected $csvLength = 0;

    /**
     * Finished rows
     *
     * @var array
     */
    protected $rows = array();

    /**
     * Current row
     *
     * @var array
     */
    protected $row = array();

    /**
     * Current field
     *
     * @var string
     */
    protected $field = '';

    /**
     * Parse the given string into an php array
     *
     * @param string $csvString
     *
     * @return array
     */
    public function parse($csvString)
    {
        $this->init($csvString);

        $delim = $this->configuration->getDelimiter();
        $lineEnding = $this->configuration->getLineEnding();
        $lineBreak1 = substr($lineEnding, 0, 1);
        $lineBreak2 = substr($lineEnding, 1, 1);

        // Main loop
        do {
            $char = $this->read();
            switch ($char) {
                // Start quoted string -> leap to the end
                case '"':
                    $this->readQuotedString();
                    break;
                // Delimiter
                case $delim:
                    $this->finishField();
                    break;
                // Line break
                case $lineBreak1:
                    // Do we need an extra character?
                    if ($lineBreak2) {
                        if ($this->preview() == $lineBreak2) {
                            $this->read();
                            $this->finishField();
                            $this->finishRow();
                        } else {
                            $this->field .= $char;
                        }
                    } else {
                        $this->finishField();
                        $this->finishRow();
                    }
                    break;
                default:
                    $this->field .= $char;
            }
        } while ($this->nextChar < $this->csvLength);

        // Finish all fields and rows
        $this->finishField(false);
        if (count($this->row)) {
            $this->finishRow();
        }

        return $this->rows;
    }

    /**
     * initial state
     *
     * @param string $csvString
     */
    protected function init($csvString)
    {
        $this->nextChar = 0;
        $this->csvString = $csvString;
        $this->csvLength = strlen($csvString);
    }

    /**
     * Read the current character and forward the pointer
     *
     * @return string one character
     * @throws EofException
     */
    protected function read()
    {
        $char = $this->preview();
        $this->nextChar++;

        return $char;
    }

    /**
     * Peak into the next character without forwarding the pointer
     *
     * @return string one character
     * @throws EofException
     */
    protected function preview()
    {
        if ($this->nextChar >= $this->csvLength) {
            throw new EofException('EOF reached');
        }
        $char = $this->csvString[$this->nextChar];

        return $char;
    }

    /**
     * Reads complete string until next quotation mark.
     * NOTE: The pointer is increased more than it is read (to simulate the quote has been read, too)
     *
     * @return string
     * @throws EofException
     */
    protected function leap()
    {
        $pos = strpos($this->csvString, '"', $this->nextChar);
        if ($pos === false) {
            throw new EofException('EOF reached (in quoted string)');
        }
        $chars = substr($this->csvString, $this->nextChar, $pos - $this->nextChar);
        $this->nextChar = $pos + 1;

        return $chars;
    }

    /**
     * Read quoted string until quote end is reached.
     */
    protected function readQuotedString()
    {
        do {
            // Leap forward to next quotation mark
            $this->field .= $this->leap();

            try {
                // Two quotes are one quote in the string
                if ($this->preview() == '"') {
                    $this->field .= $this->read();
                } else {
                    // Quote ended
                    return;
                }
            } catch (EofException $exc) {
                return;
            }
        } while (true);
    }

    /**
     * Field is complete and can be added to the row
     *
     * @param bool $force When force is true, even empty fields are added
     */
    protected function finishField($force = true)
    {
        if ($force || !empty($this->field)) {
            $this->row[] = $this->field;
        }
        $this->field = '';
    }

    /**
     * Row is complete and can be added to result
     */
    protected function finishRow()
    {
        $this->rows[] = $this->row;
        $this->row = array();
    }
}
