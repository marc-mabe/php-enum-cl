<?php declare(strict_types=1);

namespace Example;

use Mabe\Enum\Cl\EmulatedStringEnum;

/**
 * @method static UserStatus ACTIVE()
 * @method static UserStatus BANNED()
 * @method static UserStatus DELETED()
 */
final class UserStatus extends EmulatedStringEnum
{
    protected const ACTIVE = 'active';
    protected const BANNED = 'banned';
    protected const DELETED = 'deleted';
}
