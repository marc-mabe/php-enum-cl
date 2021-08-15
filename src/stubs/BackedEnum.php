<?php declare(strict_types=1);

/**
 * PHP 8.1 stub 
 *
 * @copyright 2021, Marc Bennewitz
 * @license http://github.com/marc-mabe/php-enum-cl/blob/main/LICENSE.txt New BSD License
 * @link http://github.com/marc-mabe/php-enum-cl for the canonical source repository
 */
interface BackedEnum extends UnitEnum {
    //public readonly string|int $value;

    /**
     * @param string|int $value
     * @return static
     * @psalm-pure
     */
    public static function from($value): BackedEnum;

    /**
     * @param string|int $value
     * @return null|static
     * @psalm-pure
     */
    public static function tryFrom($value): ?BackedEnum;
}
