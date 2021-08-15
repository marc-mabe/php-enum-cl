<?php declare(strict_types=1);

final class InvalidIntTypeEnumEmulated extends Mabe\Enum\Cl\IntBackedEnum
{
    const TEST = 'test';
}

final class InvalidStringTypeEnumEmulated extends Mabe\Enum\Cl\StringBackedEnum
{
    const TEST = 1;
}
