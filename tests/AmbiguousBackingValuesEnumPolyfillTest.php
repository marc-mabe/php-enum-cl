<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/AmbiguousBackingValuesEnumPolyfill.php';
}

class AmbiguousBackingValuesEnumPolyfillTest extends TestCase
{
    public function setUp(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }
    }

    public function testAmbiguousBackingValuesForIntBackedEnum()
    {
        $this->expectException('AssertionError');
        $this->expectExceptionMessage('Enum case value for AmbiguousIntValuesEnumPolyfill::TEST1 is ambiguous');
        AmbiguousIntValuesEnumPolyfill::cases();
    }

    public function testAmbiguousBackingValuesEnumPolyfillForStringBackedEnum()
    {
        $this->expectException('AssertionError');
        $this->expectExceptionMessage('Enum case value for AmbiguousStringValuesEnumPolyfill::TEST1 is ambiguous');
        AmbiguousStringValuesEnumPolyfill::cases();
    }
}
