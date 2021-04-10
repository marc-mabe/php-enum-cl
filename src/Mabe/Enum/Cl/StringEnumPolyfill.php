<?php declare(strict_types=1);

namespace Mabe\Enum\Cl;

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
