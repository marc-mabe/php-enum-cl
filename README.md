# Compatibility layer for emulating enumerations in PHP \< 8.1 but native enumerations in PHP \>= 8.1

[![Build Status](https://github.com/marc-mabe/php-enum-cl/workflows/Test/badge.svg?branch=main)](https://github.com/marc-mabe/php-enum-cl/actions?query=workflow%3ATest%20branch%3Amain)
[![Code Coverage](https://codecov.io/github/marc-mabe/php-enum-cl/coverage.svg?branch=main)](https://codecov.io/gh/marc-mabe/php-enum-cl/branch/main/)

## How-to create

**Vendor\MyEnum.php**
```php
<?php declare(strict_types=1);

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/MyEnum-emulated.php';
} else {
    require_once __DIR__ . '/MyEnum-native.php';
}
```

**Vendor\MyEnum-emulated.php**

```php
<?php declare(strict_types=1);

namespace Vendor;

use Mabe\Enum\Cl\EmulatedIntEnum;

final class MyEnum extends EmulatedIntEnum
{
    private const ZERO = 0;
    private const ONE = 1;
    private const TWO = 2;
    private const THREE = 3;
    private const FOUR = 4;
    private const FIVE = 5;
    private const SIX = 6;
    private const SEVEN = 7;
    private const EIGHT = 8;
    private const NINE = 9;
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

| Enum type           | native                                                                                                                    | emulated                                                                                                                                      |
|---------------------|---------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------|
| Unit enum           | <pre>enum ENUMNAME {<br>    use \Mabe\Enum\Cl\EnumBc;<br>    case CASENAME;<br>    // ...<br>}</pre>                      | <pre>final class ENUMNAME extends \Mabe\Enum\Cl\EmulatedUnitEnum {<br>    private const CASENAME = null;<br>    // ...<br>}</pre>             |
| Integer backed enum | <pre>enum ENUMNAME:int {<br>    use \Mabe\Enum\Cl\EnumBc;<br>    case CASENAME = CASEVALUE;<br>    // ...<br>}</pre>      | <pre>final class ENUMNAME extends \Mabe\Enum\Cl\EmulatedIntEnum {<br>    private const CASENAME = CASEVALUE;<br>    // ...<br>}</pre>         |
| String backed enum  | <pre>enum ENUMNAME:string {<br>    use \Mabe\Enum\Cl\EnumBc;<br>    case CASENAME = 'CASEVALUE';<br>    // ...<br>}</pre> | <pre>final class ENUMNAME extends \Mabe\Enum\Cl\EmulatedStringEnum {<br>    private const CASENAME = 'CASEVALUE';<br>    // ...<br>}</pre>    |

For IDE and static code analyzers I recommend adding the following docblock:

```php
/**
 * @method static ENUMNAME CASENAME()
 */
```

## How-to use

The following will work the same on PHP<8.1 (using emulated enums)
and on PHP>=8.1 (using native enums):

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

**Warning:** The following will **not** behave the same on all PHP versions:
```php
<?php declare(strict_types=1);

namespace Vendor;

MyEnum::ZERO; // PHP<8.1:  Error: Cannot access private const MyEnum::ZERO
              // PHP>=8.1: enum(MyEnum::ZERO)

serialize(MyEnum::ZERO()); // PHP<8.1:  Error: Trying to serialize a non serializable emulated enum case of MyEnum
                           // PHP>=8.1: "E:11:"MyEnum:ZERO"
```

## Additional Notes

### PHPStan

By default PHPStan will complain about unused private constants
as it can't automatically detect the special use via reflection in this case.

To avoid this you need to add the following to your `phpstan.neon[.dist]`:

```
services:
    -
        class: Mabe\Enum\Cl\PHPStan\ConstantExtension
        tags:
            - phpstan.constants.alwaysUsedClassConstantsExtension
```

For more information please read https://phpstan.org/developing-extensions/always-used-class-constants


### Included Polyfills

This library includes the following polyfills (if not already present):

* `get_debug_type`
