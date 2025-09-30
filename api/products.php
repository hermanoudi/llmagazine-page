<?php
// LL Magazine - Products API
// Backend PHP for virtual storefront

// Enable CORS for development
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration (for GoDaddy hosting)
$host = 'localhost';
$dbname = 'll_magazine_db';
$username = 'your_username'; // Replace with your GoDaddy database username
$password = 'your_password'; // Replace with your GoDaddy database password

// For development, we'll use static data
// In production, uncomment the database connection below

/*
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}
*/

// Sample products data (replace with database queries in production)
$products = [
    [
        'id' => 1,
        'name' => 'Conjunto Black',
        'category' => 'looks',
        'price' => '179,90',
        'originalPrice' => '299,90',
        'discount' => 30,
        'image' => 'assets/images/products/conjunto-black.jpg',
        'description' => 'Conjunto elegante em preto, perfeito para o dia a dia ou ocasiões especiais.',
        'colors' => ['#000000', '#333333', '#666666'],
        'sizes' => ['PP', 'P', 'M', 'G', 'GG'],
        'inStock' => true
    ],
    [
        'id' => 2,
        'name' => 'Conjunto Prime Listras',
        'category' => 'looks',
        'price' => '179,90',
        'originalPrice' => null,
        'discount' => null,
        'image' => 'assets/images/products/conjunto-prime-listras.jpg',
        'description' => 'Conjunto moderno com estampa listrada, ideal para um visual despojado e elegante.',
        'colors' => ['#FFB6C1', '#FFFFE0', '#F0F0F0'],
        'sizes' => ['PP', 'P', 'M', 'G', 'GG'],
        'inStock' => true
    ],
    [
        'id' => 3,
        'name' => 'Conjunto Corvette P',
        'category' => 'looks',
        'price' => '179,90',
        'originalPrice' => null,
        'discount' => null,
        'image' => 'assets/images/products/conjunto-corvette.jpg',
        'description' => 'Conjunto vibrante em rosa, perfeito para destacar sua personalidade.',
        'colors' => ['#FF69B4', '#FFB6C1', '#FFC0CB'],
        'sizes' => ['PP', 'P', 'M', 'G', 'GG'],
        'inStock' => true
    ],
    [
        'id' => 4,
        'name' => 'Vestido Floral Primavera',
        'category' => 'vestidos',
        'price' => '249,90',
        'originalPrice' => '349,90',
        'discount' => 25,
        'image' => 'assets/images/products/vestido-floral.jpg',
        'description' => 'Vestido romântico com estampa floral, ideal para a estação da primavera.',
        'colors' => ['#FFB6C1', '#98FB98', '#F0E68C'],
        'sizes' => ['PP', 'P', 'M', 'G', 'GG'],
        'inStock' => true
    ],
    [
        'id' => 5,
        'name' => 'Batom Avon Nude Terracota',
        'category' => 'presentes',
        'price' => '89,90',
        'originalPrice' => null,
        'discount' => null,
        'image' => 'assets/images/products/acessorios.jpg',
        'description' => 'Blusa básica em algodão, essencial para qualquer guarda-roupa.',
        'colors' => ['#FFFFFF', '#F5F5F5', '#E8E8E8'],
        'sizes' => ['PP', 'P', 'M', 'G', 'GG'],
        'inStock' => true
    ],
    [
        'id' => 6,
        'name' => 'Conjunto Infantil',
        'category' => 'infantil',
        'price' => '129,90',
        'originalPrice' => '179,90',
        'discount' => 20,
        'image' => 'assets/images/products/infantil.jpg',
        'description' => 'Conjunto Infantil.',
        'colors' => ['#87CEEB', '#B0C4DE', '#D3D3D3'],
        'sizes' => ['PP', 'P', 'M', 'G', 'GG'],
        'inStock' => true
    ],
    [
        'id' => 7,
        'name' => 'Camisa Social Vermelha',
        'category' => 'masculino',
        'price' => '159,90',
        'originalPrice' => null,
        'discount' => null,
        'image' => 'assets/images/products/camisa-vermelha.jpg',
        'description' => 'Camisa social em vermelho, elegante e versátil para o trabalho.',
        'colors' => ['#DC2626', '#B91C1C', '#991B1B'],
        'sizes' => ['PP', 'P', 'M', 'G', 'GG'],
        'inStock' => true
    ],
    [
        'id' => 8,
        'name' => 'Vestido Longo Elegante',
        'category' => 'feminino',
        'price' => '399,90',
        'originalPrice' => '499,90',
        'discount' => 15,
        'image' => 'assets/images/products/vestido-longo.jpg',
        'description' => 'Vestido longo para ocasiões especiais, com corte impecável.',
        'colors' => ['#000000', '#800080', '#4B0082'],
        'sizes' => ['PP', 'P', 'M', 'G', 'GG'],
        'inStock' => true
    ]
];

// Categories data
$categories = [
    [
        'id' => 'all',
        'name' => 'Todos os Produtos',
        'icon' => 'fas fa-tshirt'
    ],
    [
        'id' => 'looks',
        'name' => 'Looks',
        'icon' => 'fas fa-tshirt'
    ],
    [
        'id' => 'masculino',
        'name' => 'Masculino',
        'icon' => 'fas fa-tshirt'
    ],
    [
        'id' => 'feminino',
        'name' => 'Feminino',
        'icon' => 'fas fa-female'
    ],
    [
        'id' => 'presentes',
        'name' => 'Presentes',
        'icon' => 'fa fa-gift'
    ],
    [
        'id' => 'infantil',
        'name' => 'Infantil',
        'icon' => 'fa fa-child'
    ]
];

// Handle different API endpoints
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Parse the request
$path = parse_url($request, PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));

// API routing
if ($method === 'GET') {
    if (isset($pathParts[2]) && $pathParts[2] === 'products') {
        // Get all products or filter by category
        $category = $_GET['category'] ?? 'all';
        
        if ($category === 'all') {
            $response = $products;
        } else {
            $response = array_filter($products, function($product) use ($category) {
                return $product['category'] === $category;
            });
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        
    } elseif (isset($pathParts[3]) && is_numeric($pathParts[3])) {
        // Get single product by ID
        $productId = (int)$pathParts[3];
        $product = array_filter($products, function($p) use ($productId) {
            return $p['id'] === $productId;
        });
        
        if (!empty($product)) {
            echo json_encode(array_values($product)[0], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
        }
        
    } elseif (isset($pathParts[2]) && $pathParts[2] === 'categories') {
        // Get categories
        echo json_encode($categories, JSON_UNESCAPED_UNICODE);
        
    } else {
        // Default: return all products
        echo json_encode($products, JSON_UNESCAPED_UNICODE);
    }
    
} elseif ($method === 'POST') {
    // Handle form submissions (contact, newsletter, etc.)
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'contact':
                // Handle contact form
                $name = $input['name'] ?? '';
                $email = $input['email'] ?? '';
                $message = $input['message'] ?? '';
                
                // Here you would typically save to database or send email
                // For now, just return success
                echo json_encode([
                    'success' => true,
                    'message' => 'Mensagem enviada com sucesso!'
                ]);
                break;
                
            case 'newsletter':
                // Handle newsletter subscription
                $email = $input['email'] ?? '';
                
                // Here you would typically save to database
                echo json_encode([
                    'success' => true,
                    'message' => 'Inscrição realizada com sucesso!'
                ]);
                break;
                
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'No action specified']);
    }
    
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

// Database functions (for production use)
function getProducts($pdo, $category = null) {
    $sql = "SELECT * FROM products WHERE in_stock = 1";
    $params = [];
    
    if ($category && $category !== 'all') {
        $sql .= " AND category = :category";
        $params['category'] = $category;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById($pdo, $id) {
    $sql = "SELECT * FROM products WHERE id = :id AND in_stock = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCategories($pdo) {
    $sql = "SELECT DISTINCT category FROM products WHERE in_stock = 1 ORDER BY category";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Error logging function
function logError($message) {
    $logFile = 'logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message" . PHP_EOL;
    
    // Create logs directory if it doesn't exist
    if (!file_exists('logs')) {
        mkdir('logs', 0755, true);
    }
    
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

// Security functions
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Rate limiting (basic implementation)
function checkRateLimit($ip) {
    $rateLimitFile = 'logs/rate_limit.json';
    $currentTime = time();
    $window = 300; // 5 minutes
    $maxRequests = 100;
    
    if (!file_exists($rateLimitFile)) {
        $data = [];
    } else {
        $data = json_decode(file_get_contents($rateLimitFile), true) ?: [];
    }
    
    // Clean old entries
    $data = array_filter($data, function($timestamp) use ($currentTime, $window) {
        return ($currentTime - $timestamp) < $window;
    });
    
    // Check if IP has exceeded limit
    if (count($data) >= $maxRequests) {
        return false;
    }
    
    // Add current request
    $data[] = $currentTime;
    
    // Save updated data
    file_put_contents($rateLimitFile, json_encode($data));
    
    return true;
}

// Apply rate limiting
$clientIp = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
if (!checkRateLimit($clientIp)) {
    http_response_code(429);
    echo json_encode(['error' => 'Rate limit exceeded. Please try again later.']);
    exit();
}
?>
