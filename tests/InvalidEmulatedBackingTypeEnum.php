<?php declare(strict_types=1);

final class InvalidEmulatedIntEnum extends Mabe\Enum\Cl\EmulatedIntEnum
{
    private const TEST = 'test';
}

final class InvalidEmulatedStringEnum extends Mabe\Enum\Cl\EmulatedStringEnum
{
    private const TEST = 1;
}
