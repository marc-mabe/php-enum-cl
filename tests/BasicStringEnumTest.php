<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
 
if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/BasicStringEnum-polyfill.php';
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

    public function testFromSuccess()
    {
        foreach (self::NAMES_TO_VALUES as $name => $value) {
            $enum = BasicStringEnum::from($value);
            static::assertInstanceOf(BasicStringEnum::class, $enum);
            static::assertSame($value, $enum->value);
            static::assertSame($name, $enum->name);
        }
    }

    public function testFromInvalidValue()
    {
        $this->expectException('ValueError');
        $this->expectExceptionMessage('"10" is not a valid backing value for enum "BasicStringEnum"');
        BasicStringEnum::from('10');
    }

    public function testFromUnexpectedIntTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::from(): Argument #1 ($value) must be of type string, int given');
        BasicStringEnum::from(1);
    }

    public function testFromUnexpectedNullTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::from(): Argument #1 ($value) must be of type string, null given');
        BasicStringEnum::from(null);
    }

    public function testFromUnexpectedBoolTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::from(): Argument #1 ($value) must be of type string, bool given');
        BasicStringEnum::from(true);
    }

    public function testFromUnexpectedFloatTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::from(): Argument #1 ($value) must be of type string, float given');
        BasicStringEnum::from(1.1);
    }

    public function testFromUnexpectedObjTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::from(): Argument #1 ($value) must be of type string, stdClass given');
        BasicStringEnum::from(new stdClass);
    }

    /* BasicStringEnum::tryFrom() */

    public function testTryFromSuccess()
    {
        foreach (self::NAMES_TO_VALUES as $name => $value) {
            $enum = BasicStringEnum::tryFrom($value);
            static::assertInstanceOf(BasicStringEnum::class, $enum);
            static::assertSame($value, $enum->value);
            static::assertSame($name, $enum->name);
        }
    }
    
    public function testTryFromInvalidValue()
    {
        static::assertNull(BasicStringEnum::tryFrom('10'));
    }

    public function testTryFromUnexpectedIntTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::tryFrom(): Argument #1 ($value) must be of type string, int given');
        BasicStringEnum::tryFrom(1);
    }

    public function testTryFromUnexpectedNullTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::tryFrom(): Argument #1 ($value) must be of type string, null given');
        BasicStringEnum::tryFrom(null);
    }

    public function testTryFromUnexpectedBoolTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::tryFrom(): Argument #1 ($value) must be of type string, bool given');
        BasicStringEnum::tryFrom(true);
    }

    public function testTryFromUnexpectedFloatTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::tryFrom(): Argument #1 ($value) must be of type string, float given');
        BasicStringEnum::tryFrom(1.1);
    }

    public function testTryFromUnexpectedObjTypeError()
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('BasicStringEnum::tryFrom(): Argument #1 ($value) must be of type string, stdClass given');
        BasicStringEnum::tryFrom(new stdClass);
    }

    /* BasicStringEnum::cases() */

    public function testCases()
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

    public function testCallStaticSuccess()
    {
        foreach (self::NAMES_TO_VALUES as $name => $expectedValue) {
            $case = BasicStringEnum::$name();
            static::assertInstanceOf(BasicStringEnum::class, $case);
            static::assertSame($expectedValue, $case->value);
        }
    }

    public function testCallStaticSuccessCaseSensitive()
    {
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('BasicStringEnum::ZeRo does not exist');
        $case = BasicStringEnum::ZeRo();
    }
    
    public function testCallStaticUnknownCase()
    {
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('BasicStringEnum::UNKNOWN does not exist');
        BasicStringEnum::UNKNOWN();
    }
    
    public function testCallStaticUnexpectedArgs()
    {
        $this->expectException('ArgumentCountError');
        $this->expectExceptionMessage('BasicStringEnum::ZERO() expects 0 arguments, 3 given');
        BasicStringEnum::ZERO(1, 2, 3);
    }
}
