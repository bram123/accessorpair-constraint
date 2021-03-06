<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\Regular\Types\CompoundTypes;

class ArrayTypedFullProperty
{
    /** @var array<int, string> */
    private $property = [];

    /**
     * @return array<int, string>
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    /**
     * @param array<int, string> $property
     */
    public function setProperty(array $property): self
    {
        $this->property = $property;

        return $this;
    }
}
