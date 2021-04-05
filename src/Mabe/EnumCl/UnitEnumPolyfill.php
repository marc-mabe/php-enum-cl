<?php declare(strict_types=1);

namespace Mabe\EnumCl;

use ArgumentCountError;
use BadMethodCallException;
use LogicException;
use ReflectionClass;
use ReflectionClassConstant;
use TypeError;
use UnitEnum;
use ValueError;

abstract class UnitEnumPolyfill implements UnitEnum
{
    /**
     * The name of the current case
     *
     * @var string
     * @readonly
     */
    public $name;

    /**
     * A map of case names and instances by enumeration class
     *
     * @var array<class-string<BackedEnumPolyfill>, array<string, BackedEnumPolyfill>>
     */
    private static $cases = [];

    /** @param int|string $value */
    final private function __construct(string $name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * @throws LogicException Enums are not cloneable
     *                        because instances are implemented as singletons
     */
    final protected function __clone()
    {
        throw new LogicException('Enums are not cloneable');
    }

    /**
     * @throws LogicException Enums are not serializable
     *                        because instances are implemented as singletons
     *
     * @psalm-return never-return
     */
    final public function __sleep()
    {
        throw new LogicException('Enums are not serializable');
    }

    /**
     * @throws LogicException Enums are not serializable
     *                        because instances are implemented as singletons
     *
     * @psalm-return never-return
     */
    final public function __wakeup()
    {
        throw new LogicException('Enums are not serializable');
    }

    /**
     * Get an enumerator instance by the given name
     *
     * @param string $name The name of the enumerator
     * @return static
     * @throws ArgumentCountError     On unexpected number of arguments
     * @throws BadMethodCallException On an invalid or unknown name
     * @throws AssertionError         On ambiguous case constant values or invalid case constant types
     * 
     * @psalm-pure
     */
    final public static function __callStatic(string $name, array $args)
    {
        if ($args) {
            $argc = \count($args);
            throw new ArgumentCountError(static::class . "::{$name}() expects 0 arguments, {$argc} given");
        }

        self::init(static::class);

        if (isset(self::$cases[static::class][$name])) {
            return self::$cases[static::class][$name];
        }

        throw new BadMethodCallException(static::class . "::{$name} does not exist");
    }

    /**
    * Get a list of case instances
    *
    * @return static[]
    *
    * @phpstan-return array<int, static>
    * @psalm-return list<static>
    * @psalm-pure
    */
    final public static function cases(): array
    {
        self::init(static::class);

        return \array_values(self::$cases[static::class]);
    }

    /**
    * Get all available constants of the called class
    *
    * @param class-string<static> $enumClass
    * @throws AssertionError On ambiguous case constant values or invalid case constant types
    * @psalm-pure
    */
    private static function init(string $enumClass)
    {
        if (!isset(self::$cases[$enumClass])) {

            $reflection = new ReflectionClass(static::class);

            assert(
                $reflection->isFinal(),
                "Enum class \"{$enumClass}\" needs to be final"
            );

            // Case constants must be public
            /** @var array<string, int|string> $caseConstants */
            $caseConstants = [];
            if (\PHP_VERSION_ID >= 80000) {
                $caseConstants = $reflection->getConstants(ReflectionClassConstant::IS_PUBLIC);
            } elseif (\PHP_VERSION_ID >= 70100) {
                foreach ($reflection->getReflectionConstants() as $reflConstant) {
                    if ($reflConstant->isPublic()) {
                        $caseConstants[ $reflConstant->getName() ] = $reflConstant->getValue();
                    }
                }
            } else {
                $caseConstants = $reflection->getConstants();
            }

            $cases = [];
            foreach ($caseConstants as $name => $value) {
                /*
                assert(
                    (\is_subclass_of($enumClass, IntEnumPolyfill::class) && \is_int($value))
                    || (\is_subclass_of($enumClass, StringEnumPolyfill::class) && \is_string($value))
                    "Enum case constant \"{$enumClass}::{$name}\" does not match enum backing type"
                );
                */

                assert(
                    \count(\array_keys($caseConstants, $value, true)) === 1,
                    "Enum case value for {$enumClass}::{$name} is ambiguous"
                );

                $cases[$name] = new $enumClass($name, $value);
            }

            self::$cases[$enumClass] = $cases;
        }
    }
}
