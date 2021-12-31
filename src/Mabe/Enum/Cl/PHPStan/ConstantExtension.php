<?php declare(strict_types=1);

namespace Mabe\Enum\Cl\PHPStan;

use Mabe\Enum\Cl\EmulatedBackedEnum;
use Mabe\Enum\Cl\EmulatedIntEnum;
use Mabe\Enum\Cl\EmulatedStringEnum;
use Mabe\Enum\Cl\EmulatedUnitEnum;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Rules\Constants\AlwaysUsedClassConstantsExtension;

class ConstantExtension implements AlwaysUsedClassConstantsExtension
{
    public function isAlwaysUsed(ConstantReflection $constant): bool
    {
        return $constant->isPrivate()
            && ($parentClass = $constant->getDeclaringClass()->getParentClass())
            && (
                $parentClass->getName() === EmulatedUnitEnum::class
                || $parentClass->getName() === EmulatedIntEnum::class
                || $parentClass->getName() === EmulatedStringEnum::class
            );
    }
}
