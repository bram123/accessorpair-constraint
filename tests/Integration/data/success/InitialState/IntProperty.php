<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Integration\data\success\InitialState;

class IntProperty
{
    /** @var int */
    private $property = 0;

    public function getProperty(): int
    {
        return $this->property;
    }

    public function setProperty(int $property): self
    {
        $this->property = $property;

        return $this;
    }
}
