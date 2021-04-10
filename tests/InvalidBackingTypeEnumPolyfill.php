<?php declare(strict_types=1);

final class InvalidIntTypeEnumPolyfill extends Mabe\Enum\Cl\IntEnumPolyfill
{
    const TEST = 'test';
}

final class InvalidStringTypeEnumPolyfill extends Mabe\Enum\Cl\StringEnumPolyfill
{
    const TEST = 1;
}
