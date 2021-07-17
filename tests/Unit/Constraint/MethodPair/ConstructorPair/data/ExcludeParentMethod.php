<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\ConstructorPair\data;

use DigitalRevolution\AccessorPairConstraint\Tests\Unit\Constraint\MethodPair\AbstractParentClass;

class ExcludeParentMethod extends AbstractParentClass
{
    /** @var bool */
    protected $assertParentMethod = false;

    /** @var string */
    private $property;

    public function __construct(string $property, string $item)
    {
        parent::__construct($item);
        $this->property = $property;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getExpectedPairs(): array
    {
        return [['getProperty', 'property']];
    }
}
