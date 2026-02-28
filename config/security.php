<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Security Headers
    |--------------------------------------------------------------------------
    |
    | Configure security headers untuk melindungi aplikasi dari common attacks.
    | Headers ini dikirim dalam setiap HTTP response.
    |
    */

    'headers' => [
        // Prevent clickjacking attacks
        'X-Frame-Options' => 'SAMEORIGIN',

        // Prevent MIME type sniffing
        'X-Content-Type-Options' => 'nosniff',

        // Enable XSS protection di older browsers
        'X-XSS-Protection' => '1; mode=block',

        // Referrer Policy - kontrol informasi referrer
        'Referrer-Policy' => 'strict-origin-when-cross-origin',

        // Content Security Policy
        'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' cdn.jsdelivr.net fonts.googleapis.com fonts.bunny.net; font-src 'self' fonts.gstatic.com fonts.bunny.net; img-src 'self' data: https:; connect-src 'self' https:; form-action 'self' http: https:; base-uri 'self'; frame-ancestors 'self';",

        // Permissions Policy (formerly Feature Policy)
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Configuration
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting untuk mencegah brute force dan DoS attacks.
    |
    */

    'rate_limiting' => [
        // Default rate limit: 60 requests per minute
        'default' => '60,1',

        // Payment endpoints: 10 requests per minute
        'payment' => '10,1',

        // Login endpoint: 5 attempts per minute
        'login' => '5,1',

        // API endpoints: 100 requests per minute
        'api' => '100,1',

        // File upload: 20 uploads per 10 minutes
        'upload' => '20,10',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Security
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk keamanan file upload.
    |
    */

    'file_upload' => [
        // Maximum file size: 10MB
        'max_size' => 10240,

        // Allowed MIME types
        'allowed_mimes' => [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ],

        // Blocked extensions
        'blocked_extensions' => [
            'exe', 'bat', 'cmd', 'com', 'pif', 'scr',
            'vbs', 'js', 'jar', 'zip', 'rar',
            'php', 'php3', 'php4', 'php5', 'php7',
            'phtml', 'phps', 'pht', 'phar',
        ],

        // Scan uploaded files with antivirus (if available)
        'scan_with_antivirus' => false,

        // Store uploads outside public directory
        'store_outside_public' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Security
    |--------------------------------------------------------------------------
    |
    | Konfigurasi keamanan session.
    |
    */

    'session' => [
        // Enable session encryption
        'encrypt' => true,

        // Session lifetime in minutes
        'lifetime' => 120,

        // Idle timeout in minutes
        'idle_timeout' => 60,

        // Require HTTPS for session cookies in production
        'secure' => env('APP_ENV') === 'production',

        // HttpOnly flag untuk mencegah JavaScript access
        'http_only' => true,

        // SameSite policy
        'same_site' => env('APP_ENV') === 'production' ? 'strict' : 'lax',

        // Enable session invalidation on logout
        'invalidate_on_logout' => true,

        // Enable IP-based session validation
        'validate_ip' => true,

        // Enable user agent validation
        'validate_user_agent' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Security
    |--------------------------------------------------------------------------
    |
    | Konfigurasi keamanan database.
    |
    */

    'database' => [
        // Use parameterized queries (always)
        'parameterized_queries' => true,

        // Log slow queries (more than 1 second)
        'log_slow_queries' => true,
        'slow_query_threshold' => 1000,

        // Enable query auditing for sensitive tables
        'audit_sensitive_tables' => true,
        'sensitive_tables' => [
            'users',
            'permohonans',
            'pembayarans',
            'password_reset_tokens',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Encryption Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi enkripsi data.
    |
    */

    'encryption' => [
        // Cipher algorithm
        'cipher' => 'AES-256-CBC',

        // Encrypt sensitive model attributes
        'encrypt_model_attributes' => true,
        'encrypted_attributes' => [
            'App\Models\User' => ['email'],
            'App\Models\Pembayaran' => ['account_number'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Security
    |--------------------------------------------------------------------------
    |
    | Konfigurasi keamanan authentication.
    |
    */

    'authentication' => [
        // Enable account lockout after failed login attempts
        'enable_lockout' => true,
        'max_login_attempts' => 5,
        'lockout_duration_minutes' => 15,

        // Require email verification
        'require_email_verification' => true,

        // Enable two-factor authentication
        'enable_2fa' => false,

        // Require password change on first login
        'require_password_change_on_first_login' => false,

        // Password requirements
        'password' => [
            'min_length' => 12,
            'require_uppercase' => true,
            'require_lowercase' => true,
            'require_numbers' => true,
            'require_special_chars' => true,
            'prevent_common_passwords' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging & Monitoring
    |--------------------------------------------------------------------------
    |
    | Konfigurasi logging dan monitoring untuk security events.
    |
    */

    'logging' => [
        // Log authentication attempts
        'log_auth_attempts' => true,

        // Log sensitive operations
        'log_sensitive_operations' => true,

        // Log failed validations
        'log_failed_validations' => true,

        // Log all admin actions
        'log_admin_actions' => true,

        // Log payment operations
        'log_payment_operations' => true,

        // Retention period in days
        'retention_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Security
    |--------------------------------------------------------------------------
    |
    | Konfigurasi keamanan API.
    |
    */

    'api' => [
        // Require API token for endpoints
        'require_token' => true,

        // Token expiration time in hours
        'token_expiration' => 24,

        // Enable CORS
        'enable_cors' => false,

        // Allowed origins for CORS
        'cors_origins' => [
            // env('APP_URL'),
        ],

        // Enable rate limiting for API
        'rate_limiting' => true,

        // API version requirement
        'require_version_header' => false,
    ],
];
