<?php

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/..'));
$files = new RegexIterator($files, '/\.php$/');

foreach ($files as $file) {
    // Get the absolute path
    $absolutePath = realpath($file->getPathname());

    // If it's a script file, skip it
    if (strpos($absolutePath, 'scripts/') !== false) {
        continue;
    }

    // If it's a vendor file, skip it
    if (strpos($absolutePath, 'vendor/') !== false) {
        continue;
    }

    // Otherwise, replace the backend url
    echo "Replacing backend url in " . $absolutePath . "\n";
    $content = file_get_contents($absolutePath);
    $content = str_replace('%%BACKEND_URL%%', 'https://backend.frak.id', $content);
    file_put_contents($absolutePath, $content);
}
