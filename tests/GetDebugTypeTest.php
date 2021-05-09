<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class GetDebugTypeTest extends TestCase
{

    public function testNull()
    {
        static::assertSame('null', get_debug_type(null));
    }

    public function testBool()
    {
        static::assertSame('bool', get_debug_type(true));
    }

    public function testString()
    {
        static::assertSame('string', get_debug_type('str'));
    }

    public function testArray()
    {
        static::assertSame('array', get_debug_type([]));
    }

    public function testInt()
    {
        static::assertSame('int', get_debug_type(1));
    }

    public function testFloat()
    {
        static::assertSame('float', get_debug_type(1.0));
    }

    public function testObject()
    {
        static::assertSame(get_class($this), get_debug_type($this));
    }

    public function testObjectAnonymous()
    {
        $obj   = new class {};
        $class = get_class($obj);
        static::assertSame(explode('@', $class)[0] . '@anonymous', get_debug_type($obj));
    }

    public function testIncompleteClass()
    {
        $obj = new __PHP_Incomplete_Class;
        static::assertSame('__PHP_Incomplete_Class', get_debug_type($obj));
    }

    public function testResourceStream()
    {
        $fp = fopen(__FILE__, 'r');
        static::assertSame('resource (stream)', get_debug_type($fp));
        fclose($fp);
    }

    public function testResourceStreamClosed()
    {
        $fp = fopen(__FILE__, 'r');
        fclose($fp);
        static::assertSame('resource (closed)', get_debug_type($fp));
    }
}
