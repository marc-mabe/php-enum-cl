<?php declare(strict_types=1);

namespace Example;

use Mabe\Enum\Cl\StringEnumPolyfill;

final class UserStatus extends StringEnumPolyfill
{
    const ACTIVE  = 'active';
    const BANNED  = 'banned';
    const DELETED = 'deleted';
}
