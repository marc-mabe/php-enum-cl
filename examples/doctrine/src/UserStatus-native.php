<?php declare(strict_types=1);

namespace Example;

enum UserStatus:string
{
    use Mabe\Enum\Cl\EnumBc;

    case ACTIVE = 'active';
    case BANNED = 'banned';
    case DELETED = 'deleted';
}
