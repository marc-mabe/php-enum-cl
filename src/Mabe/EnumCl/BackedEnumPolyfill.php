<?php declare(strict_types=1);

namespace Mabe\EnumCl;

use ArgumentCountError;
use BackedEnum;
use BadMethodCallException;
use LogicException;
use ReflectionClass;
use ReflectionClassConstant;
use TypeError;
use ValueError;

/** @internal */
abstract class BackedEnumPolyfill implements BackedEnum
{
    /**
     * The name of the current case
     *
     * @var string
     * @readonly
     */
    public $name;

    /**
     * The value of the current case
     *
     * @var int|string
     * @readonly
     */
    public $value;

    /**
     * A map of case names and values by enumeration class
     *
     * @var array<class-string<BackedEnumPolyfill>, array<string, int|string>>
     */
    private static $caseConstants = [];

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
     * @throws LogicException Enum cases are not cloneable
     * @psalm-return never-return
     */
    final public function __clone()
    {
        throw new LogicException('Trying to clone an uncloneable object of class ' . static::class);
    }

    /**
     * @throws LogicException Emulated enum cases are not serializable
     *
     * @psalm-return never-return
     */
    final public function __sleep()
    {
        throw new LogicException('Trying to serialize a non serializable emulated enum case of ' . static::class);
    }

    /**
     * @throws LogicException Emulated enum cases are not serializable
     *
     * @psalm-return never-return
     */
    final public function __wakeup()
    {
        throw new LogicException('Trying to unserialize a non serializable emulated enum case of ' . static::class);
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
     * @param int|string $value
     * @throws ValueError     If the given value is not defined in the enumeration
     * @throws TypeError      On argument type not matching enumeration type
     * @throws AssertionError On ambiguous case constant values or invalid case constant types
     */
    final public static function from($value): BackedEnum
    {
        self::init(static::class);
        
        $name = \array_search($value, self::$caseConstants[static::class], true);
        if ($name === false) {
            if (\is_subclass_of(static::class, IntEnumPolyfill::class)) {
                if (!\is_int($value)) {
                    throw new TypeError(static::class . '::from(): Argument #1 ($value) must be of type int, ' . \get_debug_type($value) . ' given');
                }

                throw new ValueError("{$value} is not a valid backing value for enum \"" . static::class . '"');
            } elseif (\is_subclass_of(static::class, StringEnumPolyfill::class)) {
                if (!\is_string($value)) {
                    throw new TypeError(static::class . '::from(): Argument #1 ($value) must be of type string, ' . \get_debug_type($value) . ' given');
                }

                throw new ValueError("\"{$value}\" is not a valid backing value for enum \"" . static::class . '"');
            }
        }

        return self::$cases[static::class][$name];
    }
    
    /**
     * @param int|string $value
     * @throws TypeError      On argument type not matching enumeration type
     * @throws AssertionError On ambiguous case constant values or invalid case constant types
     */
    final public static function tryFrom($value): ?BackedEnum
    {
        try {
            return static::from($value);
        } catch (TypeError $e) {
            throw new TypeError(\str_replace('::from(', '::tryFrom(', $e->getMessage()));
        } catch (ValueError $e) {
            return null;
        }
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
                assert(
                    (\is_subclass_of($enumClass, IntEnumPolyfill::class) && \is_int($value))
                    || (\is_subclass_of($enumClass, StringEnumPolyfill::class) && \is_string($value)),
                    "Enum case constant \"{$enumClass}::{$name}\" does not match enum backing type"
                );
                
                assert(
                    \count(\array_keys($caseConstants, $value, true)) === 1,
                    "Enum case value for {$enumClass}::{$name} is ambiguous"
                );

                $cases[$name] = new $enumClass($name, $value);
            }

            self::$cases[$enumClass]         = $cases;
            self::$caseConstants[$enumClass] = $caseConstants;
        }
    }
}
