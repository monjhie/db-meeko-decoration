<?php
// Front controller for Vercel deployment.
// Routes each request to the matching PHP file in its ORIGINAL location
// (root, admin/, process/, user/) — no files were moved or rewritten.

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = ltrim($path, '/');

if ($path === '') {
    $path = 'index.php';
}

// Prevent directory traversal attacks
$path = str_replace('..', '', $path);

$projectRoot = realpath(__DIR__ . '/..');
$targetFile = realpath($projectRoot . '/' . $path);

if (
    $targetFile &&
    strpos($targetFile, $projectRoot) === 0 &&
    pathinfo($targetFile, PATHINFO_EXTENSION) === 'php' &&
    file_exists($targetFile)
) {
    require $targetFile;
} else {
    http_response_code(404);
    echo "404 Not Found: " . htmlspecialchars($path);
}