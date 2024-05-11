<?php

// Set the hardcoded IP address
$allowed_ip = '192.168.8.105';

// Function to get the remote IP address
function get_remote_address() {
    return $_SERVER['REMOTE_ADDR'];
}

// Function to check if the request is from the allowed IP address
function is_allowed_ip() {
    global $allowed_ip;
    return get_remote_address() === $allowed_ip;
}

// Check if the request is from the allowed IP address
if (!is_allowed_ip()) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

// Start session
session_start();

// Rate limit settings
$max_requests_per_day = 2000;
$max_requests_per_hour = 200;

// Function to check if the request is within rate limits
function is_within_rate_limit() {
    global $max_requests_per_day, $max_requests_per_hour;

    // Check requests per day
    if (!isset($_SESSION['requests_per_day'])) {
        $_SESSION['requests_per_day'] = 0;
    }
    $_SESSION['requests_per_day']++;

    if ($_SESSION['requests_per_day'] > $max_requests_per_day) {
        return false;
    }

    // Check requests per hour
    if (!isset($_SESSION['requests_per_hour'])) {
        $_SESSION['requests_per_hour'] = 0;
    }
    $_SESSION['requests_per_hour']++;

    if ($_SESSION['requests_per_hour'] > $max_requests_per_hour) {
        return false;
    }

    return true;
}

// Function to handle rate limit errors
function rate_limit_error() {
    header("HTTP/1.1 429 Too Many Requests");
    header("Retry-After: 3600"); // Retry after 1 hour
    exit("Too Many Requests");
}

// Check if request is within rate limits
if (!is_within_rate_limit()) {
    rate_limit_error();
}

// Function to serve static files
function serve_static($path) {
    $file_path = __DIR__ . '/' . $path;
    if (file_exists($file_path) && !is_dir($file_path)) {
        $content_type = mime_content_type($file_path);
        header("Content-Type: $content_type");
        readfile($file_path);
        exit;
    } else {
        http_response_code(404);
        exit;
    }
}

// Route for serving CSS files
if (isset($_GET['path']) && strpos($_GET['path'], '.css') !== false) {
    serve_static('css/' . $_GET['path']);
}

// Route for serving JavaScript files
if (isset($_GET['path']) && strpos($_GET['path'], '.js') !== false) {
    serve_static('js/' . $_GET['path']);
}

// Route for serving image files
if (isset($_GET['path']) && strpos($_GET['path'], '.jpg') !== false) {
    serve_static('images/' . $_GET['path']);
}

// Route for serving font files
if (isset($_GET['path']) && strpos($_GET['path'], '.woff') !== false) {
    serve_static('fonts/' . $_GET['path']);
}

// Route for serving HTML files
if (isset($_GET['path']) && strpos($_GET['path'], '.html') !== false) {
    serve_static($_GET['path']);
}

// Route for serving PHP files
if (isset($_GET['path']) && strpos($_GET['path'], '.php') !== false) {
    serve_static($_GET['path']);
}

// Route for serving SQL files
if (isset($_GET['path']) && strpos($_GET['path'], '.sql') !== false) {
    serve_static($_GET['path']);
}

// Add security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Error handling
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    error_log("Error: $errstr in $errfile on line $errline");
    http_response_code(500);
    exit;
});

?>
