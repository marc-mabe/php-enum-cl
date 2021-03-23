<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;


if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/InvalidBackingTypeEnumPolyfill.php';
}

class InvalidBackingTypeEnumPolyfillTest extends TestCase
{
    public function setUp(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }
    }

    public function testInvalidBackingTypeForIntBackedEnum()
    {
        $this->expectException('AssertionError');
        $this->expectExceptionMessage('Enum case constant "InvalidIntTypeEnumPolyfill::TEST" does not match enum backing type');
        InvalidIntTypeEnumPolyfill::TEST();
    }
    
    public function testInvalidBackingTypeForStringBackedEnum()
    {
        $this->expectException('AssertionError');
        $this->expectExceptionMessage('Enum case constant "InvalidStringTypeEnumPolyfill::TEST" does not match enum backing type');
        InvalidStringTypeEnumPolyfill::TEST();
    }
}
