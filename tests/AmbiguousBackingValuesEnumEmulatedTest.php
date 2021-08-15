<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/AmbiguousBackingValuesEnumEmulated.php';
}

class AmbiguousBackingValuesEnumEmulatedTest extends TestCase
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
        $this->expectExceptionMessage('Enum case value for AmbiguousIntValuesEnumEmulated::TEST1 is ambiguous');
        AmbiguousIntValuesEnumEmulated::cases();
    }

    public function testAmbiguousBackingValuesEnumPolyfillForStringBackedEnum()
    {
        $this->expectException('AssertionError');
        $this->expectExceptionMessage('Enum case value for AmbiguousStringValuesEnumEmulated::TEST1 is ambiguous');
        AmbiguousStringValuesEnumEmulated::cases();
    }
}
