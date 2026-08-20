<?php

declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    if (!str_starts_with($class, 'App\\')) {
        return;
    }

    $shared = [
        'App\\BillingDocument' => 'BillingDocument.php',
        'App\\PartnerSummary' => 'BillingDocument.php',
        'App\\FinanceCsv' => 'BillingDocument.php',
        'App\\DocumentFactory' => 'BillingDocument.php',
    ];

    if (isset($shared[$class])) {
        require_once __DIR__ . '/src/' . $shared[$class];

        return;
    }

    $relative = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 4));
    $path = __DIR__ . '/src/' . $relative . '.php';
    if (is_file($path)) {
        require $path;
    }
});
