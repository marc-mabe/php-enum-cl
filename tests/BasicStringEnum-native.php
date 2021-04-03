<?php declare(strict_types=1);

enum BasicStringEnum:string
{
    use Mabe\EnumCl\BackedEnumBc;

    case ZERO = '0';
    case ONE = '1';
    case TWO = '2';
    case THREE = '3';
    case FOUR = '4';
    case FIVE = '5';
    case SIX = '6';
    case SEVEN = '7';
    case EIGHT = '8';
    case NINE = '9';
}
