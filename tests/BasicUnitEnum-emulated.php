<?php declare(strict_types=1);

/**
 * @method static self ZERO()
 * @method static self ONE()
 * @method static self TWO()
 * @method static self THREE()
 * @method static self FOUR()
 * @method static self FIVE()
 * @method static self SIX()
 * @method static self SEVEN()
 * @method static self EIGHT()
 * @method static self NINE()
 */
final class BasicUnitEnum extends Mabe\Enum\Cl\EmulatedUnitEnum
{
    private const ZERO = null;
    private const ONE = 'one';
    private const TWO = 2.0;
    private const THREE = [3];
    private const FOUR = 4;
    private const FIVE = 5;
    private const SIX = 6;
    private const SEVEN = 7;
    private const EIGHT = 8;
    private const NINE = 9;
}
