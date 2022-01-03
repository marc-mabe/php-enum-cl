<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class GetDebugTypeTest extends TestCase
{

    public function testNull(): void
    {
        static::assertSame('null', get_debug_type(null));
    }

    public function testBool(): void
    {
        static::assertSame('bool', get_debug_type(true));
    }

    public function testString(): void
    {
        static::assertSame('string', get_debug_type('str'));
    }

    public function testArray(): void
    {
        static::assertSame('array', get_debug_type([]));
    }

    public function testInt(): void
    {
        static::assertSame('int', get_debug_type(1));
    }

    public function testFloat(): void
    {
        static::assertSame('float', get_debug_type(1.0));
    }

    public function testObject(): void
    {
        static::assertSame(get_class($this), get_debug_type($this));
    }

    public function testObjectAnonymous(): void
    {
        $obj   = new class {};
        $class = get_class($obj);
        static::assertSame(explode('@', $class)[0] . '@anonymous', get_debug_type($obj));
    }

    public function testIncompleteClass(): void
    {
        $obj = new __PHP_Incomplete_Class;
        static::assertSame('__PHP_Incomplete_Class', get_debug_type($obj));
    }

    public function testIncompleteClassUnserialize(): void
    {
        $unserializeCallbackHandler = (string)ini_set('unserialize_callback_func', '');
        $var = unserialize('O:8:"Foo\Buzz":0:{}');
        ini_set('unserialize_callback_func', $unserializeCallbackHandler);

        $this->assertSame('__PHP_Incomplete_Class', get_debug_type($var));
    }

    public function testResourceStream(): void
    {
        /** @var resource $fp */
        $fp = fopen(__FILE__, 'r');
        static::assertSame('resource (stream)', get_debug_type($fp));
        fclose($fp);
    }

    public function testResourceStreamClosed(): void
    {
        /** @var resource $fp */
        $fp = fopen(__FILE__, 'r');
        fclose($fp);
        static::assertSame('resource (closed)', get_debug_type($fp));
    }
}
