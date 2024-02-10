<?php
declare(strict_types=1);

namespace DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\Compound;

use DigitalRevolution\AccessorPairConstraint\Constraint\ValueProvider\ValueProvider;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\MockObject\Generator\Generator;

/**
 * @SuppressWarnings(PHPMD.EvalExpression)
 */
class IntersectionProvider implements ValueProvider
{
    /** @var Type[] */
    private array $typehints;

    /**
     * @param Type[] $typehints
     */
    public function __construct(array $typehints)
    {
        $this->typehints = $typehints;
    }

    /**
     * Dynamically create a new PHP abstract class with the desired parent class and/or interfaces.
     * Using PHPUnit Mock Generator to create an instance of the new class and returning it as test value.
     */
    public function getValues(): array
    {
        $interfaces = [];
        $extends    = null;
        foreach ($this->typehints as $typehint) {
            $fqnsen = (string)$typehint;
            if (interface_exists($fqnsen)) {
                $interfaces[] = $fqnsen;
            } elseif (class_exists($fqnsen)) {
                $extends = $fqnsen;
            }
        }

        $classDefinition = '';
        if ($extends !== null) {
            $classDefinition .= " extends " . $extends;
        }
        if (count($interfaces) > 0) {
            $classDefinition .= " implements " . implode(',', $interfaces);
        }
        $classDefinition .= " {}";

        /** @var class-string $className */
        $className = "AccesorPairConstraintIntersectionClass" . md5($classDefinition);
        if (class_exists($className) === false) {
            $classDefinition = "abstract class " . $className . " " . $classDefinition;
            eval($classDefinition);
        }

        if (class_exists('PHPUnit\Framework\MockObject\Generator\Generator')) {
            /** @var \PHPUnit\Framework\MockObject\Generator $mockGenerator */
            $mockGenerator = new Generator();
        } else {
            $mockGenerator = new \PHPUnit\Framework\MockObject\Generator();
        }

        // since phpunit 11 mockAbstractClass is deprecated, and will be removed in phpunit 12.
        if (method_exists($mockGenerator, 'testDouble')) {
            $instance = $mockGenerator->testDouble($className, true, true, [], [], '', false, false, false, false);
        } else {
            $instance = $mockGenerator->getMockForAbstractClass($className, [], '', false, false);
        }

        return [$instance];
    }
}
