<?php declare(strict_types=1);

/**
 * @method static AmbiguousStringValuesEnumEmulated TEST1()
 * @method static AmbiguousStringValuesEnumEmulated TEST2()
 */
final class AmbiguousStringValuesEnumEmulated extends Mabe\Enum\Cl\EmulatedStringEnum
{
    protected const TEST1 = 'test';
    protected const TEST2 = 'test';
}

/**
 * @method static AmbiguousIntValuesEnumEmulated TEST1()
 * @method static AmbiguousIntValuesEnumEmulated TEST2()
 */
final class AmbiguousIntValuesEnumEmulated extends Mabe\Enum\Cl\EmulatedIntEnum
{
    protected const TEST1 = 1;
    protected const TEST2 = 1;
}
