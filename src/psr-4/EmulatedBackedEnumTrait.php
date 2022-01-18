<?php declare(strict_types=1);

namespace Mabe\Enum\Cl;

use ArgumentCountError;
use AssertionError;
use BackedEnum;
use BadMethodCallException;
use LogicException;
use ReflectionClass;
use ReflectionClassConstant;
use TypeError;
use ValueError;

/**
 * Trait for emulated backed enumerations.
 *
 * @copyright 2022, Marc Bennewitz
 * @license http://github.com/marc-mabe/php-enum-cl/blob/main/LICENSE.txt New BSD License
 * @link http://github.com/marc-mabe/php-enum-cl for the canonical source repository
 * @internal
 *
 * @psalm-immutable
 */
trait EmulatedBackedEnumTrait
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
     * @var string|int
     * @readonly
     */
    public $value;

    /**
     * A map of case names and values by enumeration class
     *
     * @var array<class-string<static>, array<string, string|int>>
     */
    private static $caseConstants = [];

    /**
     * A map of case names and instances by enumeration class
     *
     * @var array<class-string<static>, array<string, static>>
     */
    private static $cases = [];

    /** @param string|int $value */
    final private function __construct(string $name, $value)
    {
        $this->name = $name;

        /** @phpstan-ignore-next-line */
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
     * @param string $name  The name of the enumerator
     * @param mixed[] $args Should be empty
     * @return static
     * @throws ArgumentCountError     On unexpected number of arguments
     * @throws BadMethodCallException On an invalid or unknown name
     * @throws AssertionError         On ambiguous case constant values or invalid case constant types
     */
    final public static function __callStatic(string $name, array $args)
    {
        if ($args) {
            $argc = \count($args);
            throw new ArgumentCountError(static::class . "::{$name}() expects 0 arguments, {$argc} given");
        }

        self::init(static::class);

        if (isset(self::$cases[static::class][$name])) {
            /** @phpstan-ignore-next-line */
            return self::$cases[static::class][$name];
        }

        throw new BadMethodCallException(static::class . "::{$name} does not exist or is not marked as protected");
    }

    /**
     * @param class-string<static> $enumClass
     * @param string|int $value
     * @return static
     * @throws ValueError     If the given value is not defined in the enumeration
     * @throws TypeError      On argument type not matching enumeration type
     * @throws AssertionError On ambiguous case constant values or invalid case constant types
     */
    private static function _from(string $enumClass, $value): BackedEnum
    {
        self::init($enumClass);

        $name = \array_search($value, self::$caseConstants[$enumClass], true);
        if ($name === false) {
            /** @phpstan-ignore-next-line */
            if (\is_subclass_of($enumClass, EmulatedIntEnum::class)) {
                if (!\is_int($value)) {
                    throw new TypeError($enumClass . '::from(): Argument #1 ($value) must be of type int, ' . \get_debug_type($value) . ' given');
                }

                throw new ValueError("{$value} is not a valid backing value for enum \"{$enumClass}\"");
            /** @phpstan-ignore-next-line */
            } elseif (\is_subclass_of($enumClass, EmulatedStringEnum::class)) {
                if (!\is_string($value)) {
                    throw new TypeError($enumClass . '::from(): Argument #1 ($value) must be of type string, ' . \get_debug_type($value) . ' given');
                }

                throw new ValueError("\"{$value}\" is not a valid backing value for enum \"{$enumClass}\"");
            }
        }

        /** @phpstan-ignore-next-line */
        return self::$cases[static::class][$name];
    }

    /**
     * @param class-string<static> $enumClass
     * @param string|int $value
     * @return null|static
     * @throws TypeError      On argument type not matching enumeration type
     * @throws AssertionError On ambiguous case constant values or invalid case constant types
     */
    private static function _tryFrom(string $enumClass, $value): ?BackedEnum
    {
        try {
            return self::_from($enumClass, $value);
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
     */
    final public static function cases(): array
    {
        self::init(static::class);

        /** @phpstan-ignore-next-line */
        return \array_values(self::$cases[static::class]);
    }

    /**
     * Get all available constants of the called class
     *
     * @param class-string<static> $enumClass
     * @throws AssertionError On ambiguous case constant values or invalid case constant types
     */
    private static function init(string $enumClass): void
    {
        if (!isset(self::$cases[$enumClass])) {

            $reflection = new ReflectionClass(static::class);

            assert(
                $reflection->isFinal(),
                "Enum class \"{$enumClass}\" needs to be final"
            );

            $caseConstants = [];
            $cases         = [];
            foreach ($reflection->getReflectionConstants() as $reflConstant) {
                // Case constants must be protected
                if ($reflConstant->isProtected()) {
                    $name  = $reflConstant->getName();
                    $value = $reflConstant->getValue();

                    assert(
                        /** @phpstan-ignore-next-line */
                        (\is_subclass_of($enumClass, EmulatedIntEnum::class) && \is_int($value))
                        || (\is_subclass_of($enumClass, EmulatedStringEnum::class) && \is_string($value)), /** @phpstan-ignore-line */
                        "Enum case constant \"{$enumClass}::{$name}\" does not match enum backing type"
                    );

                    assert(
                        \count(\array_keys($caseConstants, $value, true)) === 0,
                        "Enum case value for {$enumClass}::{$name} is ambiguous"
                    );

                    /** @var static $case */
                    $case = new $enumClass($name, $value);

                    $cases[$name]         = $case;
                    $caseConstants[$name] = $value;
                }
            }

            self::$cases[$enumClass]         = $cases;
            self::$caseConstants[$enumClass] = $caseConstants;
        }
    }
}
