<?php declare(strict_types=1);

/**
 * PHP 8.1 stub
 *
 * @copyright 2022, Marc Bennewitz
 * @license http://github.com/marc-mabe/php-enum-cl/blob/main/LICENSE.txt New BSD License
 * @link http://github.com/marc-mabe/php-enum-cl for the canonical source repository
 */
interface UnitEnum {
    //public readonly string $name;

    /**
     * @return static[]
     * @phpstan-return array<int, static>
     * @psalm-return list<static>
     * @psalm-pure
     */
    public static function cases(): array;
}
