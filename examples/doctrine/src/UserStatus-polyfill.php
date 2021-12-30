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
    private const ACTIVE = 'active';
    private const BANNED = 'banned';
    private const DELETED = 'deleted';
}
