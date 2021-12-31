<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/BasicIntEnum-emulated.php';
} else {
    require_once __DIR__ . '/BasicIntEnum-native.php';
}

class BasicIntEnumTest extends TestCase
{
    const NAMES_TO_VALUES = [
        'ZERO' => 0,
        'ONE' => 1,
        'TWO' => 2,
        'THREE' => 3,
        'FOUR' => 4,
        'FIVE' => 5,
        'SIX' => 6,
        'SEVEN' => 7,
        'EIGHT' => 8,
        'NINE' => 9,
    ];

    /* BasicIntEnum::from() */

    public function testFromSuccess(): void
    {
        foreach (self::NAMES_TO_VALUES as $name => $value) {
            $enum = BasicIntEnum::from($value);
            static::assertInstanceOf(BasicIntEnum::class, $enum);
            static::assertSame($value, $enum->value);
            static::assertSame($name, $enum->name);
        }
    }

    public function testFromInvalidValue(): void
    {
        $this->expectException('ValueError');
        $this->expectExceptionMessage('10 is not a valid backing value for enum "BasicIntEnum"');
        BasicIntEnum::from(10);
    }

    public function testFromUnexpectedStrTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::from(): Argument #1 ($value) must be of type int, string given');
        BasicIntEnum::from('1');
    }

    public function testFromUnexpectedNullTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::from(): Argument #1 ($value) must be of type int, null given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::from(null);
    }

    public function testFromUnexpectedBoolTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::from(): Argument #1 ($value) must be of type int, bool given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::from(true);
    }

    public function testFromUnexpectedFloatTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::from(): Argument #1 ($value) must be of type int, float given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::from(1.1);
    }

    public function testFromUnexpectedObjTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::from(): Argument #1 ($value) must be of type int, stdClass given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::from(new stdClass);
    }

    /* BasicIntEnum::tryFrom() */

    public function testTryFromSuccess(): void
    {
        foreach (self::NAMES_TO_VALUES as $name => $value) {
            /** @var BasicIntEnum $enum */
            $enum = BasicIntEnum::tryFrom($value);
            static::assertInstanceOf(BasicIntEnum::class, $enum);
            static::assertSame($value, $enum->value);
            static::assertSame($name, $enum->name);
        }
    }

    public function testTryFromInvalidValue(): void
    {
        static::assertNull(BasicIntEnum::tryFrom(10));
    }

    public function testTryFromUnexpectedStrTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::tryFrom(): Argument #1 ($value) must be of type int, string given');
        BasicIntEnum::tryFrom('1');
    }

    public function testTryFromUnexpectedNullTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::tryFrom(): Argument #1 ($value) must be of type int, null given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::tryFrom(null);
    }

    public function testTryFromUnexpectedBoolTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::tryFrom(): Argument #1 ($value) must be of type int, bool given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::tryFrom(true);
    }

    public function testTryFromUnexpectedFloatTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::tryFrom(): Argument #1 ($value) must be of type int, float given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::tryFrom(1.1);
    }

    public function testTryFromUnexpectedObjTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicIntEnum::tryFrom(): Argument #1 ($value) must be of type int, stdClass given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::tryFrom(new stdClass);
    }

    /* BasicIntEnum::cases() */

    public function testCases(): void
    {
        $cases = BasicIntEnum::cases();
        static::assertIsArray($cases);
        static::assertSame(count($cases), count(self::NAMES_TO_VALUES));

        foreach ($cases as $case) {
            static::assertInstanceOf(BasicIntEnum::class, $case);
        }

        foreach (self::NAMES_TO_VALUES as $expectedName => $expectedValue) {
            static::assertTrue(array_reduce($cases, function ($carry, $case) use ($expectedName) {
                return $case->name === $expectedName ? true : $carry;
            }, null));

            static::assertTrue(array_reduce($cases, function ($carry, $case) use ($expectedValue) {
                return $case->value === $expectedValue ? true : $carry;
            }, null));
        }
    }

    /* BasicIntEnum::__callStatic() */

    public function testCallStaticSuccess(): void
    {
        foreach (self::NAMES_TO_VALUES as $name => $expectedValue) {
            $case = BasicIntEnum::$name();
            static::assertInstanceOf(BasicIntEnum::class, $case);
            static::assertSame($name, $case->name);
            static::assertSame($expectedValue, $case->value);
        }
    }

    public function testCallStaticSuccessCaseSensitive(): void
    {
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('BasicIntEnum::ZeRo does not exist');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::ZeRo();
    }

    public function testCallStaticUnknownCase(): void
    {
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('BasicIntEnum::UNKNOWN does not exist');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::UNKNOWN();
    }

    public function testCallStaticUnexpectedArgs(): void
    {
        $this->expectException('ArgumentCountError');
        $this->expectExceptionMessage('BasicIntEnum::ZERO() expects 0 arguments, 3 given');

        /** @phpstan-ignore-next-line */
        BasicIntEnum::ZERO(1, 2, 3);
    }

    /* BasicIntEnum::__clone() */

    public function testCloneShouldFail(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('Cloning native enum cases will fatal error');
        }

        $case = BasicIntEnum::from(1);

        $this->expectException('LogicException');
        $this->expectExceptionMessage('Trying to clone an uncloneable object of class BasicIntEnum');
        clone $case;
    }

    /* un/serialize */

    public function testSerialize(): void
    {
        $case = BasicIntEnum::ONE();

        if (PHP_VERSION_ID >= 80100) {
            static::assertSame('E:16:"BasicIntEnum:ONE";', serialize($case));
        } else {
            $this->expectException('LogicException');
            $this->expectExceptionMessage('Trying to serialize a non serializable emulated enum case of BasicIntEnum');
            serialize($case);
        }
    }

    public function testUnserialize(): void
    {
        $case = BasicIntEnum::ONE();

        if (PHP_VERSION_ID >= 80100) {
            static::assertSame($case, unserialize('E:16:"BasicIntEnum:ONE";'));
        } else {
            $this->expectException('LogicException');
            $this->expectExceptionMessage('Trying to unserialize a non serializable emulated enum case of BasicIntEnum');
            unserialize('O:12:"BasicIntEnum":0:{}');
        }
    }
}
