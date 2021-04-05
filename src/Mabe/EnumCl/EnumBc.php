<?php declare(strict_types=1);

namespace Mabe\EnumCl;

use ArgumentCountError;
use BadMethodCallException;
use ReflectionEnum;
use ReflectionException;

/**
 * Backward compatibility trait for native enumerations of PHP >= 8.1
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
