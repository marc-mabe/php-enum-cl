<?php declare(strict_types=1);

interface BackedEnum extends UnitEnum {
    //public int|string $value;

    /** @param int|string $value */
    public static function from($value): self;

    /** @param int|string $value */
    public static function tryFrom($value): ?self;
}
