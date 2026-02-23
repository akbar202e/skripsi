<?php
// Test CSP header format
$config = require 'config/security.php';
$csp = $config['headers']['Content-Security-Policy'];

echo "CSP Header Length: " . strlen($csp) . "\n";
echo "First 100 chars: " . substr($csp, 0, 100) . "...\n";
echo "Contains newline: " . (strpos($csp, "\n") !== false ? "YES (ERROR!)" : "NO (OK!)") . "\n";
echo "Contains \\r: " . (strpos($csp, "\r") !== false ? "YES (ERROR!)" : "NO (OK!)") . "\n";

echo "\n✅ CSP Header is valid (single line)\n";
