<?php declare(strict_types=1);

namespace Example;

use Mabe\Enum\Cl\StringEnumPolyfill;

/**
 * @method static UserStatus ACTIVE()
 * @method static UserStatus BANNED()
 * @method static UserStatus DELETED()
 */
final class UserStatus extends StringEnumPolyfill
{
    /** @internal */
    const ACTIVE = 'active';

    /** @internal */
    const BANNED = 'banned';

    /** @internal */
    const DELETED = 'deleted';
}
