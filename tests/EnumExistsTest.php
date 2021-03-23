<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class EnumExistsTest extends TestCase
{
    public function setUp(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }
    }

    public function testIntEnumPolyfill()
    {
        eval('final class ' . __FUNCTION__ . ' extends IntEnumPolyfill {}');
        static::assertTrue(enum_exists(__FUNCTION__));
    }
    
    public function testStringEnumPolyfill()
    {
        eval('final class ' . __FUNCTION__ . ' extends StringEnumPolyfill {}');
        static::assertTrue(enum_exists(__FUNCTION__));
    }
    
    public function testInterfaceUnitEnum()
    {
        static::assertFalse(enum_exists('UnitEnum'));
    }
    
    public function testInterfaceBackedEnum()
    {
        static::assertFalse(enum_exists('BackedEnum'));
    }
    
    public function testNonEnumClass()
    {
        static::assertFalse(enum_exists('stdClass'));
    }
    
    public function testAutoloadTrue()
    {
        $enumClass = __FUNCTION__;
        $called = 0;
        $classLoader = function (string $class) use ($enumClass, &$called) {
            if ($class === $enumClass) {
                $called++;
                eval('final class ' . $class . ' extends StringEnumPolyfill {}');
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
        $enumClass = __FUNCTION__;
        $called = 0;
        $classLoader = function (string $class) use ($enumClass, &$called) {
            if ($class === $enumClass) {
                $called++;
                eval('final class ' . $class . ' extends StringEnumPolyfill {}');
            }
        };
        
        spl_autoload_register($classLoader);
        $result = enum_exists(__FUNCTION__, false);
        spl_autoload_unregister($classLoader);
        
        static::assertFalse($result);
        static::assertSame(0, $called);
    }
}
