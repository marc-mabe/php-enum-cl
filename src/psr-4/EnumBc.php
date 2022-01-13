<?php declare(strict_types=1);

namespace Mabe\Enum\Cl;

use ArgumentCountError;
use BadMethodCallException;
use ReflectionEnum;
use ReflectionException;

/**
 * Backward compatibility trait for native enumerations.
 *
 * @copyright 2022, Marc Bennewitz
 * @license http://github.com/marc-mabe/php-enum-cl/blob/main/LICENSE.txt New BSD License
 * @link http://github.com/marc-mabe/php-enum-cl for the canonical source repository
 *
 * @psalm-immutable
 */
trait EnumBc
{
    /**
    * Get an enumeration case by the given name
    *
    * @param string $name The name of the enumeration case
    * @throws ArgumentCountError     On unexpected number of arguments
    * @throws BadMethodCallException On an invalid or unknown name
    *
    * @psalm-pure
    */
    final public static function __callStatic(string $name, array $args): static
    {
        if ($args) {
            $argc = \count($args);
            throw new ArgumentCountError(self::class . "::{$name}() expects 0 arguments, {$argc} given");
        }

        try {
            return (new ReflectionEnum(self::class))->getCase($name)->getValue();
        } catch (ReflectionException $e) {
            throw new BadMethodCallException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
