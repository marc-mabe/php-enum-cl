<?php declare(strict_types=1);

if (PHP_VERSION_ID < 80000) {
    require_once __DIR__ . '/EmulatedIntEnum-74.php';
} else {
    require_once __DIR__ . '/EmulatedIntEnum-80.php';
}
