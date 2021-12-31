<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/NonFinalEnumEmulated.php';
}

class NonFinalEnumEmulatedTest extends TestCase
{
    public function setUp(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }
    }

    public function testNonFinalAssertionError(): void
    {
        $this->expectException('AssertionError');
        $this->expectExceptionMessage('Enum class "NonFinalEnumEmulated" needs to be final');
        NonFinalEnumEmulated::TEST();
    }
}
