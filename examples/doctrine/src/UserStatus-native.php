<?php declare(strict_types=1);

namespace Example;

/**
 * @method static UserStatus ACTIVE()
 * @method static UserStatus BANNED()
 * @method static UserStatus DELETED()
 */
enum UserStatus:string
{
    use Mabe\Enum\Cl\EnumBc;

    /** @internal */
    case ACTIVE = 'active';

    /** @internal */
    case BANNED = 'banned';

    /** @internal */
    case DELETED = 'deleted';
}
