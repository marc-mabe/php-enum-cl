<?php declare(strict_types=1);

final class InvalidIntTypeEnumPolyfill extends IntEnumPolyfill
{
    const TEST = 'test';
}

final class InvalidStringTypeEnumPolyfill extends StringEnumPolyfill
{
    const TEST = 1;
}
