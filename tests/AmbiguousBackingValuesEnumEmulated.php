<?php declare(strict_types=1);

/**
 * @method static AmbiguousStringValuesEnumEmulated TEST1()
 * @method static AmbiguousStringValuesEnumEmulated TEST2()
 */
final class AmbiguousStringValuesEnumEmulated extends Mabe\Enum\Cl\EmulatedStringEnum
{
    private const TEST1 = 'test';
    private const TEST2 = 'test';
}

/**
 * @method static AmbiguousIntValuesEnumEmulated TEST1()
 * @method static AmbiguousIntValuesEnumEmulated TEST2()
 */
final class AmbiguousIntValuesEnumEmulated extends Mabe\Enum\Cl\EmulatedIntEnum
{
    private const TEST1 = 1;
    private const TEST2 = 1;
}
