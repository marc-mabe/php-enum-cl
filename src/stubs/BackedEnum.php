<?php declare(strict_types=1);

if (PHP_VERSION_ID >= 70400) {
    interface BackedEnum extends UnitEnum {
        //public int|string $value;

        /** @param int|string $value */
        public static function from($value): self;

        /** @param int|string $value */
        public static function tryFrom($value): ?self;
    }
} else {
    interface BackedEnum extends UnitEnum {
        //public int|string $value;

        /** @param int|string $value */
        public static function from($value): BackedEnum;

        /** @param int|string $value */
        public static function tryFrom($value): ?BackedEnum;
    }
}


