<?php declare(strict_types=1);

final class InvalidIntTypeEnumPolyfill extends Mabe\EnumCl\IntEnumPolyfill
{
    const TEST = 'test';
}

final class InvalidStringTypeEnumPolyfill extends Mabe\EnumCl\StringEnumPolyfill
{
    const TEST = 1;
}
