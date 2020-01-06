<?php

namespace Kuborgh\CsvBundle\Configuration;

use Kuborgh\CsvBundle\Exception\InvalidConfigurationException;

/**
 * Configuration for parser and generator
 */
abstract class AbstractConfiguration
{
    public const LINE_ENDING_CRLF = "\r\n";
    public const LINE_ENDING_LF = "\n";
    public const LINE_ENDING_CR = "\r";

    /**
     * Delimiting character
     *
     * @var string
     */
    protected $delimiter = ',';

    /**
     * Line Ending
     * @var
     */
    protected $lineEnding = self::LINE_ENDING_CRLF;

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * Set delimiter
     *
     * @param string $delimiter
     *
     * @throws InvalidConfigurationException
     */
    public function setDelimiter($delimiter): void
    {
        if (strlen($delimiter) !== 1) {
            throw new InvalidConfigurationException('CSV Configuration error: Delimiter must be exactly 1 character');
        }

        $this->delimiter = $delimiter;
    }

    /**
     * Get lineEnding
     *
     * @return mixed
     */
    public function getLineEnding()
    {
        return $this->lineEnding;
    }

    /**
     * Set lineEnding
     *
     * @param mixed $lineEnding
     *
     * @throws InvalidConfigurationException
     */
    public function setLineEnding($lineEnding): void
    {
        if (!in_array($lineEnding, array(self::LINE_ENDING_CR, self::LINE_ENDING_CRLF, self::LINE_ENDING_LF), true)) {
            throw new InvalidConfigurationException('Invalid line ending provided. Only CR,LF and CRLF allowed');
        }

        $this->lineEnding = $lineEnding;
    }
}
