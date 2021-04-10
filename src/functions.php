<?php declare(strict_types=1);

namespace {
    if (!function_exists('get_debug_type')) {
        function get_debug_type($value): string
        {
            switch (true) {
                case null === $value: return 'null';
                case is_bool($value): return 'bool';
                case is_string($value): return 'string';
                case is_array($value): return 'array';
                case is_int($value): return 'int';
                case is_float($value): return 'float';
                case is_object($value): break;
                case $value instanceof __PHP_Incomplete_Class: return '__PHP_Incomplete_Class';
                default:
                    if (null === $type = @get_resource_type($value)) {
                        return 'unknown';
                    }

                    if ('Unknown' === $type) {
                        $type = 'closed';
                    }

                    return "resource ($type)";
            }

            $class = get_class($value);

            if (false === strpos($class, '@')) {
                return $class;
            }

            return (get_parent_class($class) ?: key(class_implements($class)) ?: 'class').'@anonymous';
        }
    }
}

namespace Mabe\Enum\Cl {
    /**
    * Checks if the given enumeration has been natively defined
    * or for PHP < 8.1 it's a class emulating enumerations via Mabe\EnumCl\IntEnumPolyfill or Mabe\EnumCl\StringEnumPolyfill
    *
    * @param string $enum     The enum name. The name is matched in a case-insensitive manner.
    * @param bool   $autoload Whether or not to call __autoload by default. 
    */
    function enum_exists(string $enum, bool $autoload = true) : bool
    {
        if (\PHP_VERSION_ID >= 80100) {
            return \enum_exists($enum, $autoload);
        }

        return \class_exists($enum, $autoload) && (
            \is_a($enum, __NAMESPACE__ . '\\IntEnumPolyfill', true)
            || \is_a($enum, __NAMESPACE__ . '\\StringEnumPolyfill', true)
        );
    }
}

