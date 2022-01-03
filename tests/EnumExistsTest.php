<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function Mabe\Enum\Cl\enum_exists;

class EnumExistsTest extends TestCase
{
    public function testUnitEnumNative(): void
    {
        if (PHP_VERSION_ID < 80100) {
            $this->markTestSkipped('This test is for PHP >= 8.1 only');
        }

        eval('enum ' . __FUNCTION__ . ' {}');
        static::assertTrue(enum_exists(__FUNCTION__));
    }

    public function testEmulatedUnitEnum(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        eval('final class ' . __FUNCTION__ . ' extends Mabe\Enum\Cl\EmulatedUnitEnum {}');
        static::assertTrue(enum_exists(__FUNCTION__));
    }

    public function testEmulatedIntEnum(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        eval('final class ' . __FUNCTION__ . ' extends Mabe\Enum\Cl\EmulatedIntEnum {}');
        static::assertTrue(enum_exists(__FUNCTION__));
    }

    public function testEmulatedStringEnum(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        eval('final class ' . __FUNCTION__ . ' extends Mabe\Enum\Cl\EmulatedStringEnum {}');
        static::assertTrue(enum_exists(__FUNCTION__));
    }

    public function testInterfaceUnitEnum(): void
    {
        static::assertFalse(enum_exists('UnitEnum'));
    }

    public function testOtherImplementsUnitEnum(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        eval(
            'final class ' . __FUNCTION__ . ' implements UnitEnum {'
            . ' public static function cases(): array {}'
            . '}'
        );
        static::assertFalse(enum_exists(__FUNCTION__));
    }

    public function testInterfaceBackedEnum(): void
    {
        static::assertFalse(enum_exists('BackedEnum'));
    }

    public function testOtherImplementsBackedEnum(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        $argType = PHP_VERSION_ID >= 80000 ? 'int|string' : '';
        $retType = PHP_VERSION_ID >= 80000 ? 'static' : 'BackedEnum';

        eval(
            'final class ' . __FUNCTION__ . ' implements BackedEnum {'
            . " public static function from({$argType} \$value): {$retType} {}"
            . " public static function tryFrom({$argType} \$value): ?{$retType} {}"
            . ' public static function cases(): array {}'
            . '}'
        );

        static::assertFalse(enum_exists(__FUNCTION__));
    }

    public function testNonEnumClass(): void
    {
        static::assertFalse(enum_exists('stdClass'));
    }

    public function testAutoloadTrue(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        $enumClass = __FUNCTION__;
        $called = 0;
        $classLoader = function (string $class) use ($enumClass, &$called) {
            if ($class === $enumClass) {
                $called++;
                eval('final class ' . $class . ' extends Mabe\Enum\Cl\EmulatedStringEnum {}');
            }
        };

        spl_autoload_register($classLoader);
        $result = enum_exists(__FUNCTION__, true);
        spl_autoload_unregister($classLoader);

        static::assertTrue($result);
        static::assertSame(1, $called);
    }

    public function testAutoloadFalse(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        $enumClass = __FUNCTION__;
        $called = 0;
        $classLoader = function (string $class) use ($enumClass, &$called) {
            if ($class === $enumClass) {
                $called++;
                eval('final class ' . $class . ' extends Mabe\Enum\Cl\EmulatedStringEnum {}');
            }
        };

        spl_autoload_register($classLoader);
        $result = enum_exists(__FUNCTION__, false);
        spl_autoload_unregister($classLoader);

        static::assertFalse($result);
        static::assertSame(0, $called);
    }
}
