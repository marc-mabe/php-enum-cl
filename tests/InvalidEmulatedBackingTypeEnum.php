<?php declare(strict_types=1);

/**
 * @method static self TEST()
 */
final class InvalidEmulatedIntEnum extends Mabe\Enum\Cl\EmulatedIntEnum
{
    protected const TEST = 'test';
}

/**
 * @method static self TEST()
 */
final class InvalidEmulatedStringEnum extends Mabe\Enum\Cl\EmulatedStringEnum
{
    protected const TEST = 1;
}
