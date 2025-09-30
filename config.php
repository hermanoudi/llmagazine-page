<?php
// LL Magazine - Configuration File
// Configurações para hospedagem na GoDaddy

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'll_magazine_db');
define('DB_USER', 'your_username'); // Substitua pelo seu usuário do GoDaddy
define('DB_PASS', 'your_password'); // Substitua pela sua senha do GoDaddy

// Site Configuration
define('SITE_NAME', 'LL Magazine');
define('SITE_URL', 'https://yourdomain.com'); // Substitua pelo seu domínio
define('SITE_EMAIL', 'contato@yourdomain.com'); // Substitua pelo seu email

// WhatsApp Configuration
define('WHATSAPP_NUMBER', '5511999999999'); // Substitua pelo seu número
define('WHATSAPP_MESSAGE', 'Olá! Gostaria de saber mais sobre este produto da LL Magazine:');

// Security Configuration
define('ENABLE_HTTPS', true);
define('ENABLE_CORS', true);
define('RATE_LIMIT_REQUESTS', 100);
define('RATE_LIMIT_WINDOW', 300); // 5 minutes

// File Upload Configuration
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Email Configuration (for contact forms)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');

// Development/Production Mode
define('DEBUG_MODE', false); // Set to true for development
define('LOG_ERRORS', true);

// Cache Configuration
define('CACHE_ENABLED', true);
define('CACHE_DURATION', 3600); // 1 hour

// API Configuration
define('API_VERSION', '1.0');
define('API_RATE_LIMIT', 1000); // requests per hour

// Social Media Links
define('INSTAGRAM_URL', 'https://instagram.com/llmagazine');
define('FACEBOOK_URL', 'https://facebook.com/llmagazine');
define('WHATSAPP_URL', 'https://wa.me/' . WHATSAPP_NUMBER);

// Business Information
define('BUSINESS_NAME', 'LL Magazine');
define('BUSINESS_ADDRESS', 'Sua Rua, 123 - Seu Bairro - Sua Cidade/SP');
define('BUSINESS_PHONE', '+55 11 99999-9999');
define('BUSINESS_CNPJ', '00.000.000/0001-00');

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Error Reporting
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', ENABLE_HTTPS ? 1 : 0);
ini_set('session.use_strict_mode', 1);

// Memory and Time Limits
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 30);

// Headers for Security
if (ENABLE_HTTPS) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// CORS Headers
if (ENABLE_CORS) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
}

// Function to get configuration value
function getConfig($key, $default = null) {
    return defined($key) ? constant($key) : $default;
}

// Function to check if running in production
function isProduction() {
    return !DEBUG_MODE;
}

// Function to get full URL
function getFullUrl($path = '') {
    return SITE_URL . '/' . ltrim($path, '/');
}

// Function to get WhatsApp URL
function getWhatsAppUrl($message = '') {
    $encodedMessage = urlencode($message);
    return 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . $encodedMessage;
}

// Function to log errors
function logError($message, $context = []) {
    if (!LOG_ERRORS) return;
    
    $logFile = 'logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $contextStr = !empty($context) ? ' | Context: ' . json_encode($context) : '';
    $logMessage = "[$timestamp] $message$contextStr" . PHP_EOL;
    
    // Create logs directory if it doesn't exist
    if (!file_exists('logs')) {
        mkdir('logs', 0755, true);
    }
    
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Function to validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to generate CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to verify CSRF token
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
