<?php declare(strict_types=1);

namespace Mabe\Enum\Cl;

use ArgumentCountError;
use AssertionError;
use BadMethodCallException;
use LogicException;
use ReflectionClass;
use ReflectionClassConstant;
use UnitEnum;

/**
 * Abstract base class for emulated unit enumerations.
 *
 * @copyright 2021, Marc Bennewitz
 * @license http://github.com/marc-mabe/php-enum-cl/blob/main/LICENSE.txt New BSD License
 * @link http://github.com/marc-mabe/php-enum-cl for the canonical source repository
 *
 * @psalm-immutable
 */
abstract class EmulatedUnitEnum implements UnitEnum
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
     * @var array<class-string<EmulatedBackedEnum>, array<string, EmulatedBackedEnum>>
     */
    private static $cases = [];

    final private function __construct(string $name)
    {
        $this->name = $name;
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
                $caseConstants = $reflection->getConstants(ReflectionClassConstant::IS_PRIVATE);
            } else {
                foreach ($reflection->getReflectionConstants() as $reflConstant) {
                    if ($reflConstant->isPrivate()) {
                        $caseConstants[ $reflConstant->getName() ] = $reflConstant->getValue();
                    }
                }
            }

            $cases = [];
            foreach ($caseConstants as $name => $value) {
                $cases[$name] = new $enumClass($name);
            }

            self::$cases[$enumClass] = $cases;
        }
    }
}
