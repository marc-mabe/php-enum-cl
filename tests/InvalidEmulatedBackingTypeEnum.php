<?php declare(strict_types=1);

final class InvalidEmulatedIntEnum extends Mabe\Enum\Cl\EmulatedIntEnum
{
    const TEST = 'test';
}

final class InvalidEmulatedStringEnum extends Mabe\Enum\Cl\EmulatedStringEnum
{
    const TEST = 1;
}
