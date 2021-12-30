<?php declare(strict_types=1);

if (PHP_VERSION_ID < 80100) {
    require_once __DIR__ . '/UserStatus-emulated.php';
} else {
    require_once __DIR__ . '/UserStatus-native.php';
}
