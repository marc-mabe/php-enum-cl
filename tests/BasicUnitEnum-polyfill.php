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
final class BasicUnitEnum extends Mabe\Enum\Cl\UnitEnumPolyfill
{
    /** @internal */
    const ZERO = null;
    
    /** @internal */
    const ONE = 'one';
    
    /** @internal */
    const TWO = 2.0;
    
    /** @internal */
    const THREE = [3];
    
    /** @internal */
    const FOUR = 4;
    
    /** @internal */
    const FIVE = 5;
    
    /** @internal */
    const SIX = 6;
    
    /** @internal */
    const SEVEN = 7;
    
    /** @internal */
    const EIGHT = 8;
    
    /** @internal */
    const NINE = 9;
}
