<?php declare(strict_types=1);

/**
 * PHP 8.1 stub for PHP 8.0
 *
 * @copyright 2022, Marc Bennewitz
 * @license http://github.com/marc-mabe/php-enum-cl/blob/main/LICENSE.txt New BSD License
 * @link http://github.com/marc-mabe/php-enum-cl for the canonical source repository
 */
interface BackedEnum extends UnitEnum {
    //public readonly string|int $value;

    /**
     * @psalm-pure
     */
    public static function from(string|int $value): static;

    /**
     * @psalm-pure
     */
    public static function tryFrom(string|int $value): ?static;
}
