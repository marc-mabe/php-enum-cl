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
enum BasicIntEnum:int
{
    use Mabe\EnumCl\BackedEnumBc;

    /** @internal */
    case ZERO = 0;
    
    /** @internal */
    case ONE = 1;
    
    /** @internal */
    case TWO = 2;
    
    /** @internal */
    case THREE = 3;
    
    /** @internal */
    case FOUR = 4;
    
    /** @internal */
    case FIVE = 5;
    
    /** @internal */
    case SIX = 6;
    
    /** @internal */
    case SEVEN = 7;
    
    /** @internal */
    case EIGHT = 8;
    
    /** @internal */
    case NINE = 9;
}
