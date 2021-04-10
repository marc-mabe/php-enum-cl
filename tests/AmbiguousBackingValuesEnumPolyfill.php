<?php declare(strict_types=1);

final class AmbiguousStringValuesEnumPolyfill extends Mabe\Enum\Cl\StringEnumPolyfill
{
    const TEST1 = 'test';
    const TEST2 = 'test';
}

final class AmbiguousIntValuesEnumPolyfill extends Mabe\Enum\Cl\IntEnumPolyfill
{
    const TEST1 = 1;
    const TEST2 = 1;
}
