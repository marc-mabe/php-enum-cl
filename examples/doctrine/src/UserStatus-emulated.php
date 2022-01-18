<?php declare(strict_types=1);

namespace Example;

use Mabe\Enum\Cl\EmulatedStringEnum;

/**
 * @method static self ACTIVE()
 * @method static self BANNED()
 * @method static self DELETED()
 */
final class UserStatus extends EmulatedStringEnum
{
    protected const ACTIVE = 'active';
    protected const BANNED = 'banned';
    protected const DELETED = 'deleted';
}
