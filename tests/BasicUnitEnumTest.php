<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/BasicUnitEnum-emulated.php';
} else {
    require_once __DIR__ . '/BasicUnitEnum-native.php';
}

class BasicUnitEnumTest extends TestCase
{
    const NAMES = [
        'ZERO',
        'ONE',
        'TWO',
        'THREE',
        'FOUR',
        'FIVE',
        'SIX',
        'SEVEN',
        'EIGHT',
        'NINE',
    ];

    /* BasicUnitEnum::cases() */

    public function testCases(): void
    {
        $cases = BasicUnitEnum::cases();
        static::assertIsArray($cases);
        static::assertSame(count($cases), count(self::NAMES));

        foreach ($cases as $case) {
            static::assertInstanceOf(BasicUnitEnum::class, $case);
        }

        foreach (self::NAMES as $name) {
            static::assertTrue(array_reduce($cases, function ($carry, $case) use ($name) {
                return $case->name === $name ? true : $carry;
            }, null));
        }
    }

    public function testUnitEnumDoesNotCareAboutValue(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('This test is for PHP < 8.1 only');
        }

        $class = __FUNCTION__;

        eval(
            'final class ' . $class . ' extends Mabe\Enum\Cl\EmulatedUnitEnum {'
            . ' protected const TEST1 = "test";'
            . ' protected const TEST2 = "test";'
            . '}'
        );

        $test1 = $class::TEST1();
        $test2 = $class::TEST2();

        static::assertNotSame($test1, $test2);
        static::assertSame($test1, $class::TEST1());
        static::assertSame($test2, $class::TEST2());
        static::assertSame([$test1, $test2], $class::cases());
    }

    /* BasicUnitEnum::__callStatic() */

    public function testCallStaticSuccess(): void
    {
        foreach (self::NAMES as $name) {
            $case = BasicUnitEnum::$name();
            static::assertInstanceOf(BasicUnitEnum::class, $case);
            static::assertSame($name, $case->name);
        }
    }

    public function testCallStaticSuccessCaseSensitive(): void
    {
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('BasicUnitEnum::ZeRo does not exist');

        /** @phpstan-ignore-next-line */
        BasicUnitEnum::ZeRo();
    }

    public function testCallStaticUnknownCase(): void
    {
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('BasicUnitEnum::UNKNOWN does not exist');

        /** @phpstan-ignore-next-line */
        BasicUnitEnum::UNKNOWN();
    }

    public function testCallStaticUnexpectedArgs(): void
    {
        $this->expectException('ArgumentCountError');
        $this->expectExceptionMessage('BasicUnitEnum::ZERO() expects 0 arguments, 3 given');

        /** @phpstan-ignore-next-line */
        BasicUnitEnum::ZERO(1, 2, 3);
    }

    /* BasicUnitEnum::__clone() */

    public function testCloneShouldFail(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('Cloning native enum cases will fatal error');
        }

        $case = BasicUnitEnum::ONE();

        $this->expectException('LogicException');
        $this->expectExceptionMessage('Trying to clone an uncloneable object of class BasicUnitEnum');
        clone $case;
    }

    /* un/serialize */

    public function testSerialize(): void
    {
        $case = BasicUnitEnum::ONE();

        if (PHP_VERSION_ID >= 80100) {
            static::assertSame('E:17:"BasicUnitEnum:ONE";', serialize($case));
        } else {
            $this->expectException('LogicException');
            $this->expectExceptionMessage('Trying to serialize a non serializable emulated enum case of BasicUnitEnum');
            serialize($case);
        }
    }

    public function testUnserialize(): void
    {
        $case = BasicUnitEnum::ONE();

        if (PHP_VERSION_ID >= 80100) {
            static::assertSame($case, unserialize('E:17:"BasicUnitEnum:ONE";'));
        } else {
            $this->expectException('LogicException');
            $this->expectExceptionMessage('Trying to unserialize a non serializable emulated enum case of BasicUnitEnum');
            unserialize('O:13:"BasicUnitEnum":0:{}');
        }
    }
}
