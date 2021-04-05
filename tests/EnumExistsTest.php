<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function Mabe\EnumCl\enum_exists;

class EnumExistsTest extends TestCase
{
    public function testIntEnumPolyfill()
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        eval('final class ' . __FUNCTION__ . ' extends Mabe\EnumCl\IntEnumPolyfill {}');
        static::assertTrue(enum_exists(__FUNCTION__));
    }
    
    public function testStringEnumPolyfill()
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }
        
        eval('final class ' . __FUNCTION__ . ' extends Mabe\EnumCl\StringEnumPolyfill {}');
        static::assertTrue(enum_exists(__FUNCTION__));
    }
    
    public function testInterfaceUnitEnum()
    {
        static::assertFalse(enum_exists('UnitEnum'));
    }

    public function testOtherImplementsUnitEnum()
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

    public function testInterfaceBackedEnum()
    {
        static::assertFalse(enum_exists('BackedEnum'));
    }
    
    public function testOtherImplementsBackedEnum()
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestIncomplete('FIXME');
        }
    
        $valueType = PHP_VERSION_ID >= 80100 ? 'string|int' : '';
        eval(
            'final class ' . __FUNCTION__ . ' implements BackedEnum {'
            . ' public static function from(' . $valueType . ' $value): self {}'
            . ' public static function tryFrom(' . $valueType . ' $value): self {}'
            . ' public static function cases(): array {}'
            . '}'
        );
        static::assertFalse(enum_exists(__FUNCTION__));
    }
    
    public function testNonEnumClass()
    {
        static::assertFalse(enum_exists('stdClass'));
    }
    
    public function testAutoloadTrue()
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        $enumClass = __FUNCTION__;
        $called = 0;
        $classLoader = function (string $class) use ($enumClass, &$called) {
            if ($class === $enumClass) {
                $called++;
                eval('final class ' . $class . ' extends Mabe\EnumCl\StringEnumPolyfill {}');
            }
        };
        
        spl_autoload_register($classLoader);
        $result = enum_exists(__FUNCTION__, true);
        spl_autoload_unregister($classLoader);
        
        static::assertTrue($result);
        static::assertSame(1, $called);
    }
    
    public function testAutoloadFalse()
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        $enumClass = __FUNCTION__;
        $called = 0;
        $classLoader = function (string $class) use ($enumClass, &$called) {
            if ($class === $enumClass) {
                $called++;
                eval('final class ' . $class . ' extends Mabe\EnumCl\StringEnumPolyfill {}');
            }
        };
        
        spl_autoload_register($classLoader);
        $result = enum_exists(__FUNCTION__, false);
        spl_autoload_unregister($classLoader);
        
        static::assertFalse($result);
        static::assertSame(0, $called);
    }
}
