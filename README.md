# Compatibility layer for emulating enumerations in PHP \< 8.1 and use native enumerations in PHP \>= 8.1

[![Build Status](https://github.com/marc-mabe/php-enum-cl/workflows/Test/badge.svg?branch=main)](https://github.com/marc-mabe/php-enum-cl/actions?query=workflow%3ATest%20branch%3Amain)
[![Code Coverage](https://codecov.io/github/marc-mabe/php-enum-cl/coverage.svg?branch=main)](https://codecov.io/gh/marc-mabe/php-enum-cl/branch/main/)

## How-to create

**Vendor\MyEnum.php**
```php
<?php declare(strict_types=1);

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/MyEnum-polyfill.php';
} else {
    require_once __DIR__ . '/MyEnum-native.php';
}

```

**Vendor\MyEnum-polyfill.php**

```php
<?php declare(strict_types=1);

namespace Vendor;

use Mabe\Enum\Cl\EmulatedIntEnum;

final class MyEnum extends EmulatedIntEnum
{
    const ZERO = 0;
    const ONE = 1;
    const TWO = 2;
    const THREE = 3;
    const FOUR = 4;
    const FIVE = 5;
    const SIX = 6;
    const SEVEN = 7;
    const EIGHT = 8;
    const NINE = 9;
}

```

**Vendor\MyEnum-native.php**
```php
<?php declare(strict_types=1);

namespace Vendor;

use Mabe\Enum\Cl\EnumBc;

enum MyEnum:int
{
    use EnumBc;

    case ZERO = 0;
    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
    case FOUR = 4;
    case FIVE = 5;
    case SIX = 6;
    case SEVEN = 7;
    case EIGHT = 8;
    case NINE = 9;
}

```

## How-to use

The following will work on PHP<8.1 using the polyfill and on PHP>=8.1 using the native version:

```php
<?php declare(strict_types=1);

namespace Vendor;

use function Mabe\Enum\Cl\enum_exists;

$zero = MyEnum::ZERO();
$zero = MyEnum::from(0);
$zero = MyEnum::tryFrom(0);
$cases = MyEnum::cases();

$zero->value; // 0
$zero->name;  // ZERO

$zero instanceof \UnitEnum;   // true
$zero instanceof \BackedEnum; // true

MyEnum::ZERO() === MyEnum::from(0);     // true
MyEnum::from(0) === MyEnum::tryFrom(0); // true

enum_exists(MyEnum::class); // true
enum_exists('stdClass');    // false

```

The following will **not** behave the same on all PHP versions:
```php
<?php declare(strict_types=1);

namespace Vendor;

MyEnum::ZERO; // 1 on PHP<8.1
              // enum(MyEnum::ZERO) on PHP>=8.1
```
