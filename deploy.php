<?php
/**
 * Build and pack the app for deployment (e.g. shared hosting).
 *
 * Usage (from project root):
 *   php deploy.php              # Run composer + npm build, then create zip
 *   php deploy.php --skip-build # Only create zip (use existing vendor + build)
 *
 * Creates: deploy/Deploy-DD-Mon-YY.zip (e.g. deploy/Deploy-10-Mar-26.zip)
 * Upload the zip to the server, extract, copy .env.example to .env, configure, then run deploy_check.php.
 *
 * @see DEPLOYMENT_SHARED_HOSTING.md
 */

$base = __DIR__;
$skipBuild = in_array('--skip-build', $argv ?? [], true);

// --- 1. Build (optional) ---
if (!$skipBuild) {
    echo "Running composer install --no-dev --optimize-autoloader ...\n";
    passthru('composer install --no-dev --optimize-autoloader', $cExit);
    if ($cExit !== 0) {
        fwrite(STDERR, "Composer failed. Fix errors and run again, or use --skip-build.\n");
        exit(1);
    }
    echo "Running npm run build ...\n";
    passthru('npm run build', $nExit);
    if ($nExit !== 0) {
        fwrite(STDERR, "npm run build failed. Fix errors and run again, or use --skip-build.\n");
        exit(1);
    }
} else {
    echo "Skipping build (--skip-build). Using existing vendor and public/build.\n";
}

// --- 2. Zip output in deploy/ folder ---
$deployDir = $base . DIRECTORY_SEPARATOR . 'deploy';
if (!is_dir($deployDir)) {
    mkdir($deployDir, 0755, true);
}
$date = date('d-M-y'); // e.g. 10-Mar-26
$zipName = "Deploy-{$date}.zip";
$zipPath = $deployDir . DIRECTORY_SEPARATOR . $zipName;

// Paths to exclude (relative to $base). No leading slash.
$excludePaths = [
    '.git',
    '.github',
    'node_modules',
    '.env',
    '.env.backup',
    '.env.production',
    '.phpunit.cache',
    'phpunit.xml',
    'Pest.php',
    'tests',
    '.idea',
    '.vscode',
    '.fleet',
    '.nova',
    '.zed',
    'storage' . DIRECTORY_SEPARATOR . 'logs',
    'storage' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'data',
    'storage' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'sessions',
    'storage' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'views',
    'storage' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'testing',
    'storage' . DIRECTORY_SEPARATOR . 'pail',
    'public' . DIRECTORY_SEPARATOR . 'hot',
    'deploy',
];

// Also exclude any existing Deploy-*.zip
$excludePrefixes = ['Deploy-'];

function shouldExclude(string $relativePath, array $excludePaths, array $excludePrefixes): bool
{
    $normalized = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
    foreach ($excludePaths as $ex) {
        $exNorm = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $ex);
        if ($normalized === $exNorm || str_starts_with($normalized . DIRECTORY_SEPARATOR, $exNorm . DIRECTORY_SEPARATOR)) {
            return true;
        }
    }
    foreach ($excludePrefixes as $prefix) {
        if (str_starts_with(basename($relativePath), $prefix)) {
            return true;
        }
    }
    return false;
}

// --- 3. Create zip ---
if (!class_exists('ZipArchive')) {
    fwrite(STDERR, "ZipArchive is required. Enable php-zip.\n");
    exit(1);
}

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Cannot create zip: {$zipPath}\n");
    exit(1);
}

$iter = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($base, RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::FOLLOW_SYMLINKS),
    RecursiveIteratorIterator::SELF_FIRST
);

$count = 0;
foreach ($iter as $path) {
    $real = $path->getRealPath();
    if ($real === false || $real === $zipPath) {
        continue;
    }
    $relative = substr($real, strlen($base) + 1);
    if (shouldExclude($relative, $excludePaths, $excludePrefixes)) {
        continue;
    }
    if ($path->isDir()) {
        $zip->addEmptyDir($relative);
    } else {
        $zip->addFile($real, $relative);
        $count++;
    }
}

$zip->close();
echo "Created deploy" . DIRECTORY_SEPARATOR . "{$zipName} with {$count} files.\n";
echo "Next: upload to server, extract, copy .env.example to .env, then run php deploy_check.php on the server.\n";
