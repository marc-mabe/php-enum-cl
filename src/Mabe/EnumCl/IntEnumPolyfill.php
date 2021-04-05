<?php declare(strict_types=1);

namespace Mabe\EnumCl;

abstract class IntEnumPolyfill extends BackedEnumPolyfill
{
    /**
    * The value of the current case
    *
    * @var int
    + @readonly
    */
    public $value;
}
