<?php declare(strict_types=1);

namespace Mabe\EnumCl;

abstract class StringEnumPolyfill extends BackedEnumPolyfill
{
    /**
    * The value of the current case
    *
    * @var string
    + @readonly
    */
    public $value;
}
