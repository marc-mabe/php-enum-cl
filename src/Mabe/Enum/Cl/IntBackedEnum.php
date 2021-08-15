<?php declare(strict_types=1);

namespace Mabe\Enum\Cl;

/**
 * Abstract base class for emulated integer backed enumerations.
 *
 * @copyright 2021, Marc Bennewitz
 * @license http://github.com/marc-mabe/php-enum-cl/blob/main/LICENSE.txt New BSD License
 * @link http://github.com/marc-mabe/php-enum-cl for the canonical source repository
 *
 * @psalm-immutable
 */
abstract class IntBackedEnum extends EmulatedBackedEnum
{
    /**
    * The value of the current case
    *
    * @var int
    + @readonly
    */
    public $value;
}
