<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;


if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/InvalidEmulatedBackingTypeEnum.php';
}

class InvalidEmulatedBackingTypeEnumTest extends TestCase
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
        $this->expectExceptionMessage('Enum case constant "InvalidEmulatedIntEnum::TEST" does not match enum backing type');
        InvalidEmulatedIntEnum::TEST();
    }
    
    public function testInvalidBackingTypeForStringBackedEnum()
    {
        $this->expectException('AssertionError');
        $this->expectExceptionMessage('Enum case constant "InvalidEmulatedStringEnum::TEST" does not match enum backing type');
        InvalidEmulatedStringEnum::TEST();
    }
}
