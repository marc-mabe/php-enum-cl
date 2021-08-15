<?php declare(strict_types=1);

final class AmbiguousStringValuesEnumEmulated extends Mabe\Enum\Cl\StringBackedEnum
{
    const TEST1 = 'test';
    const TEST2 = 'test';
}

final class AmbiguousIntValuesEnumEmulated extends Mabe\Enum\Cl\IntBackedEnum
{
    const TEST1 = 1;
    const TEST2 = 1;
}
