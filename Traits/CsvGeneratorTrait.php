<?php

namespace Kuborgh\CsvBundle\Traits;

use Kuborgh\CsvBundle\Generator\GeneratorInterface;
use RuntimeException;

/**
 * Helper for setter-injection of a csv generator
 */
trait CsvGeneratorTrait
{
    /**
     * @var GeneratorInterface
     */
    private $csvGenerator;

    /**
     * Set csv generator
     *
     * @param GeneratorInterface $csvGenerator
     */
    public function setCsvGenerator($csvGenerator): void
    {
        $this->csvGenerator = $csvGenerator;
    }

    /**
     * Get csv generator
     *
     * @return GeneratorInterface
     *
     * @throws RuntimeException
     */
    protected function getCsvGenerator(): GeneratorInterface
    {
        if (null === $this->csvGenerator) {
            throw new RuntimeException('CSV Generator not injected into '.get_class($this));
        }

        return $this->csvGenerator;
    }

    /**
     * Convenience wrapper
     *
     * @param array $array
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected function generateCsv(array $array): string
    {
        return $this->getCsvGenerator()->generate($array);
    }
}
