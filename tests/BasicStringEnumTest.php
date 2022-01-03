<?php declare(strict_types=1);

use Mabe\Enum\Cl\EmulatedStringEnum;
use PHPUnit\Framework\TestCase;

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/BasicStringEnum-emulated.php';
} else {
    require_once __DIR__ . '/BasicStringEnum-native.php';
}

class BasicStringEnumTest extends TestCase
{
    const NAMES_TO_VALUES = [
        'ZERO' => '0',
        'ONE' => '1',
        'TWO' => '2',
        'THREE' => '3',
        'FOUR' => '4',
        'FIVE' => '5',
        'SIX' => '6',
        'SEVEN' => '7',
        'EIGHT' => '8',
        'NINE' => '9',
    ];

    /* BasicStringEnum::from() */

    public function testFromSuccess(): void
    {
        foreach (self::NAMES_TO_VALUES as $name => $value) {
            $enum = BasicStringEnum::from($value);
            static::assertInstanceOf(BasicStringEnum::class, $enum);
            static::assertSame($value, $enum->value);
            static::assertSame($name, $enum->name);
        }
    }

    public function testFromInvalidValue(): void
    {
        $this->expectException('ValueError');
        $this->expectExceptionMessage('"10" is not a valid backing value for enum "BasicStringEnum"');
        BasicStringEnum::from('10');
    }

    public function testFromUnexpectedIntTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::from(): Argument #1 ($value) must be of type string, int given');

        /** @phpstan-ignore-next-line */
        BasicStringEnum::from(1);
    }

    public function testFromUnexpectedNullTypeError(): void
    {
        if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100) {
            $class = EmulatedStringEnum::class;
            $type  = 'string|int';
        } else {
            $class = BasicStringEnum::class;
            $type  = 'string';
        }

        $this->expectException('TypeError');
        $this->expectExceptionMessage("{$class}::from(): Argument #1 (\$value) must be of type {$type}, null given");

        /** @phpstan-ignore-next-line */
        BasicStringEnum::from(null);
    }

    public function testFromUnexpectedBoolTypeError(): void
    {
        if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100) {
            $class = EmulatedStringEnum::class;
            $type  = 'string|int';
        } else {
            $class = BasicStringEnum::class;
            $type  = 'string';
        }

        $this->expectException('TypeError');
        $this->expectExceptionMessage("{$class}::from(): Argument #1 (\$value) must be of type {$type}, bool given");

        /** @phpstan-ignore-next-line */
        BasicStringEnum::from(true);
    }

    public function testFromUnexpectedFloatTypeError(): void
    {
        if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100) {
            $class = EmulatedStringEnum::class;
            $type  = 'string|int';
        } else {
            $class = BasicStringEnum::class;
            $type  = 'string';
        }

        $this->expectException('TypeError');
        $this->expectExceptionMessage("{$class}::from(): Argument #1 (\$value) must be of type {$type}, float given");

        /** @phpstan-ignore-next-line */
        BasicStringEnum::from(1.1);
    }

    public function testFromUnexpectedObjTypeError(): void
    {
        if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100) {
            $class = EmulatedStringEnum::class;
            $type  = 'string|int';
        } else {
            $class = BasicStringEnum::class;
            $type  = 'string';
        }

        $this->expectException('TypeError');
        $this->expectExceptionMessage("{$class}::from(): Argument #1 (\$value) must be of type {$type}, stdClass given");

        /** @phpstan-ignore-next-line */
        BasicStringEnum::from(new stdClass);
    }

    /* BasicStringEnum::tryFrom() */

    public function testTryFromSuccess(): void
    {
        foreach (self::NAMES_TO_VALUES as $name => $value) {
            /** @var BasicStringEnum $enum */
            $enum = BasicStringEnum::tryFrom($value);
            static::assertInstanceOf(BasicStringEnum::class, $enum);
            static::assertSame($value, $enum->value);
            static::assertSame($name, $enum->name);
        }
    }

    public function testTryFromInvalidValue(): void
    {
        static::assertNull(BasicStringEnum::tryFrom('10'));
    }

    public function testTryFromUnexpectedIntTypeError(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::tryFrom(): Argument #1 ($value) must be of type string, int given');

        /** @phpstan-ignore-next-line */
        BasicStringEnum::tryFrom(1);
    }

    public function testTryFromUnexpectedNullTypeError(): void
    {
        if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100) {
            $class = EmulatedStringEnum::class;
            $type  = 'string|int';
        } else {
            $class = BasicStringEnum::class;
            $type  = 'string';
        }

        $this->expectException('TypeError');
        $this->expectExceptionMessage("{$class}::tryFrom(): Argument #1 (\$value) must be of type {$type}, null given");

        /** @phpstan-ignore-next-line */
        BasicStringEnum::tryFrom(null);
    }

    public function testTryFromUnexpectedBoolTypeError(): void
    {
        if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100) {
            $class = EmulatedStringEnum::class;
            $type  = 'string|int';
        } else {
            $class = BasicStringEnum::class;
            $type  = 'string';
        }

        $this->expectException('TypeError');
        $this->expectExceptionMessage("{$class}::tryFrom(): Argument #1 (\$value) must be of type {$type}, bool given");

        /** @phpstan-ignore-next-line */
        BasicStringEnum::tryFrom(true);
    }

    public function testTryFromUnexpectedFloatTypeError(): void
    {
        if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100) {
            $class = EmulatedStringEnum::class;
            $type  = 'string|int';
        } else {
            $class = BasicStringEnum::class;
            $type  = 'string';
        }

        $this->expectException('TypeError');
        $this->expectExceptionMessage("{$class}::tryFrom(): Argument #1 (\$value) must be of type {$type}, float given");

        /** @phpstan-ignore-next-line */
        BasicStringEnum::tryFrom(1.1);
    }

    public function testTryFromUnexpectedObjTypeError(): void
    {
        if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100) {
            $class = EmulatedStringEnum::class;
            $type  = 'string|int';
        } else {
            $class = BasicStringEnum::class;
            $type  = 'string';
        }

        $this->expectException('TypeError');
        $this->expectExceptionMessage("{$class}::tryFrom(): Argument #1 (\$value) must be of type {$type}, stdClass given");

        /** @phpstan-ignore-next-line */
        BasicStringEnum::tryFrom(new stdClass);
    }

    /* BasicStringEnum::cases() */

    public function testCases(): void
    {
        $cases = BasicStringEnum::cases();
        static::assertIsArray($cases);
        static::assertSame(count($cases), count(self::NAMES_TO_VALUES));

        foreach ($cases as $case) {
            static::assertInstanceOf(BasicStringEnum::class, $case);
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

    /* BasicStringEnum::__callStatic() */

    public function testCallStaticSuccess(): void
    {
        foreach (self::NAMES_TO_VALUES as $name => $expectedValue) {
            $case = BasicStringEnum::$name();
            static::assertInstanceOf(BasicStringEnum::class, $case);
            static::assertSame($expectedValue, $case->value);
        }
    }

    public function testCallStaticSuccessCaseSensitive(): void
    {
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('BasicStringEnum::ZeRo does not exist');

        /** @phpstan-ignore-next-line */
        BasicStringEnum::ZeRo();
    }

    public function testCallStaticUnknownCase(): void
    {
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('BasicStringEnum::UNKNOWN does not exist');

        /** @phpstan-ignore-next-line */
        BasicStringEnum::UNKNOWN();
    }

    public function testCallStaticUnexpectedArgs(): void
    {
        $this->expectException('ArgumentCountError');
        $this->expectExceptionMessage('BasicStringEnum::ZERO() expects 0 arguments, 3 given');

        /** @phpstan-ignore-next-line */
        BasicStringEnum::ZERO(1, 2, 3);
    }

    /* BasicStringEnum::__clone() */

    public function testCloneShouldFail(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            $this->markTestSkipped('Cloning native enum cases will fatal error');
        }

        $case = BasicStringEnum::from('1');

        $this->expectException('LogicException');
        $this->expectExceptionMessage('Trying to clone an uncloneable object of class BasicStringEnum');
        clone $case;
    }

    /* un/serialize */

    public function testSerialize(): void
    {
        $case = BasicStringEnum::ONE();

        if (PHP_VERSION_ID >= 80100) {
            static::assertSame('E:19:"BasicStringEnum:ONE";', serialize($case));
        } else {
            $this->expectException('LogicException');
            $this->expectExceptionMessage('Trying to serialize a non serializable emulated enum case of BasicStringEnum');
            serialize($case);
        }
    }

    public function testUnserialize(): void
    {
        $case = BasicStringEnum::ONE();

        if (PHP_VERSION_ID >= 80100) {
            static::assertSame($case, unserialize('E:19:"BasicStringEnum:ONE";'));
        } else {
            $this->expectException('LogicException');
            $this->expectExceptionMessage('Trying to unserialize a non serializable emulated enum case of BasicStringEnum');
            unserialize('O:15:"BasicStringEnum":0:{}');
        }
    }
}
