<?php declare(strict_types=1);

final class AmbiguousStringValuesEnumEmulated extends Mabe\Enum\Cl\EmulatedStringEnum
{
    private const TEST1 = 'test';
    private const TEST2 = 'test';
}

final class AmbiguousIntValuesEnumEmulated extends Mabe\Enum\Cl\EmulatedIntEnum
{
    private const TEST1 = 1;
    private const TEST2 = 1;
}
