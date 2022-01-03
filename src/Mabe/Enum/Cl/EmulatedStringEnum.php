<?php declare(strict_types=1);

namespace Mabe\Enum\Cl;

/**
 * Abstract base class for emulated string backed enumerations.
 *
 * @copyright 2022, Marc Bennewitz
 * @license http://github.com/marc-mabe/php-enum-cl/blob/main/LICENSE.txt New BSD License
 * @link http://github.com/marc-mabe/php-enum-cl for the canonical source repository
 *
 * @psalm-immutable
 */
abstract class EmulatedStringEnum extends EmulatedBackedEnum
{
    /**
    * The value of the current case
    *
    * @var string
    + @readonly
    */
    public $value;
}
