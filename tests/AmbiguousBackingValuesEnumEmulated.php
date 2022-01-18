<?php declare(strict_types=1);

/**
 * @method static self TEST1()
 * @method static self TEST2()
 */
final class AmbiguousStringValuesEnumEmulated extends Mabe\Enum\Cl\EmulatedStringEnum
{
    protected const TEST1 = 'test';
    protected const TEST2 = 'test';
}

/**
 * @method static self TEST1()
 * @method static self TEST2()
 */
final class AmbiguousIntValuesEnumEmulated extends Mabe\Enum\Cl\EmulatedIntEnum
{
    protected const TEST1 = 1;
    protected const TEST2 = 1;
}
