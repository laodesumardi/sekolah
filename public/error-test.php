<?php
// Simple error handler for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/../storage/logs/php-errors.log");

// Custom error handler
set_error_handler(function($severity, $message, $file, $line) {
    $error = "Error: $message in $file on line $line\n";
    error_log($error);
    if (ini_get("display_errors")) {
        echo "<div style=\"color: red; background: #ffe6e6; padding: 10px; margin: 10px; border: 1px solid red;\">";
        echo "<strong>PHP Error:</strong> $message<br>";
        echo "<strong>File:</strong> $file<br>";
        echo "<strong>Line:</strong> $line<br>";
        echo "</div>";
    }
});

echo "Error handler loaded successfully!";
?>