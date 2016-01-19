<?php

namespace Kuborgh\CsvBundle\Traits;

use Kuborgh\CsvBundle\Generator\GeneratorInterface;

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
    public function setCsvGenerator($csvGenerator)
    {
        $this->csvGenerator = $csvGenerator;
    }

    /**
     * Get csv generator
     *
     * @return GeneratorInterface
     * @throws \Exception
     */
    protected function getCsvGenerator()
    {
        if (is_null($this->csvGenerator)) {
            throw new \Exception('CSV Generator not injected into '.get_class($this));
        }

        return $this->csvGenerator;
    }

    /**
     * Convenience wrapper
     *
     * @param array $array
     *
     * @return string
     */
    protected function generateCsv($array)
    {
        return $this->getCsvGenerator()->generate($array);
    }
}
