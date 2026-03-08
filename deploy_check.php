<?php
/**
 * Run this on the server to find missing files/folders: php deploy_check.php
 * Or open in browser: https://yoursite.com/deploy_check.php (DELETE after use!)
 */

$base = __DIR__;
$issues = [];
$fixed = [];
$ok = [];

// 1. Vendor (most common - not in git)
if (!is_file($base . '/vendor/autoload.php')) {
    $issues[] = 'vendor/autoload.php is missing. Run: composer install --optimize-autoloader --no-dev';
} else {
    $ok[] = 'vendor';
}

// 2. .env
if (!is_file($base . '/.env')) {
    $issues[] = '.env is missing. Copy .env.example to .env and set APP_KEY, DB_*, APP_URL';
} else {
    $ok[] = '.env';
}

// 3. Required storage directories (create if missing)
$storageDirs = [
    'storage/app/public',
    'storage/app/private',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/framework/testing',
    'storage/logs',
];

foreach ($storageDirs as $dir) {
    $path = $base . '/' . $dir;
    if (!is_dir($path)) {
        if (@mkdir($path, 0755, true)) {
            $fixed[] = "Created: $dir";
        } else {
            $issues[] = "Missing and could not create: $dir (create it manually and chmod 775)";
        }
    } else {
        if (!is_writable($path)) {
            $issues[] = "Not writable: $dir (chmod 775 $dir)";
        }
    }
}

// 4. bootstrap/cache writable
$bootCache = $base . '/bootstrap/cache';
if (is_dir($bootCache) && !is_writable($bootCache)) {
    $issues[] = 'bootstrap/cache is not writable (chmod 775 bootstrap/cache)';
} elseif (!is_dir($bootCache)) {
    $issues[] = 'bootstrap/cache is missing';
}

// Output
header('Content-Type: text/plain; charset=utf-8');
echo "Laravel deployment check\n";
echo str_repeat('-', 40) . "\n";
if (!empty($fixed)) {
    echo "Fixed:\n";
    foreach ($fixed as $f) echo "  $f\n";
    echo "\n";
}
if (!empty($ok)) {
    echo "OK: " . implode(', ', $ok) . "\n\n";
}
if (!empty($issues)) {
    echo "Issues to fix:\n";
    foreach ($issues as $i) echo "  $i\n";
    echo "\nFix the issues above, then delete this file (deploy_check.php).\n";
} else {
    echo "All checks passed. Delete this file (deploy_check.php) for security.\n";
}
