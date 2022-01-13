<?php declare(strict_types=1);

if (PHP_VERSION_ID < 80000) {
    require_once __DIR__ . '/../php74/BackedEnum.php';
} else {
    require_once __DIR__ . '/../php80/BackedEnum.php';
}
