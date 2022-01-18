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
    protected const ZERO = null;
    protected const ONE = 'one';
    protected const TWO = 2.0;
    protected const THREE = [3];
    protected const FOUR = 4;
    protected const FIVE = 5;
    protected const SIX = 6;
    protected const SEVEN = 7;
    protected const EIGHT = 8;
    protected const NINE = 9;
}
