<?php
// LL Magazine - Installation Script
// Script para configurar o banco de dados e verificar requisitos

require_once 'config.php';

// Check if already installed
if (file_exists('installed.lock')) {
    die('Sistema já foi instalado. Para reinstalar, remova o arquivo installed.lock');
}

$errors = [];
$success = [];

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    $errors[] = 'PHP 7.4 ou superior é necessário. Versão atual: ' . PHP_VERSION;
}

// Check required extensions
$requiredExtensions = ['pdo', 'pdo_mysql', 'json', 'curl', 'mbstring'];
foreach ($requiredExtensions as $ext) {
    if (!extension_loaded($ext)) {
        $errors[] = "Extensão PHP '$ext' não está instalada";
    }
}

// Check file permissions
$directories = ['logs', 'assets/images', 'assets/images/products'];
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true)) {
            $errors[] = "Não foi possível criar o diretório '$dir'";
        }
    }
    
    if (!is_writable($dir)) {
        $errors[] = "Diretório '$dir' não tem permissão de escrita";
    }
}

// Test database connection
if (empty($errors)) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $success[] = 'Conexão com o banco de dados estabelecida com sucesso';
        
        // Create database if it doesn't exist
        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
        $pdo->exec("USE " . DB_NAME);
        
        // Create tables
        $sql = "
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            category VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            original_price DECIMAL(10,2) NULL,
            discount INT NULL,
            image VARCHAR(500) NOT NULL,
            description TEXT NULL,
            colors JSON NULL,
            sizes JSON NULL,
            in_stock BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(100) NOT NULL UNIQUE,
            icon VARCHAR(100) NULL,
            active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS newsletter (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) NOT NULL UNIQUE,
            setting_value TEXT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );
        ";
        
        $pdo->exec($sql);
        $success[] = 'Tabelas do banco de dados criadas com sucesso';
        
        // Insert default categories
        $categories = [
            ['name' => 'Looks', 'slug' => 'looks', 'icon' => 'fa fa-camera'],
            ['name' => 'Masculinho', 'slug' => 'masculino', 'icon' => 'fas fa-tshirt'],
            ['name' => 'Feminino', 'slug' => 'feminino', 'icon' => 'fas fa-female'],
            ['name' => 'Blusas', 'slug' => 'blusas', 'icon' => 'fas fa-tshirt'],
            ['name' => 'Infantil', 'slug' => 'infantil', 'icon' => 'fa fa-child']
        ];
        
        $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name, slug, icon) VALUES (?, ?, ?)");
        foreach ($categories as $category) {
            $stmt->execute([$category['name'], $category['slug'], $category['icon']]);
        }
        $success[] = 'Categorias padrão inseridas';
        
        // Insert default settings
        $settings = [
            ['setting_key' => 'site_name', 'setting_value' => 'LL Magazine'],
            ['setting_key' => 'whatsapp_number', 'setting_value' => WHATSAPP_NUMBER],
            ['setting_key' => 'whatsapp_message', 'setting_value' => WHATSAPP_MESSAGE],
            ['setting_key' => 'business_address', 'setting_value' => BUSINESS_ADDRESS],
            ['setting_key' => 'business_phone', 'setting_value' => BUSINESS_PHONE],
            ['setting_key' => 'instagram_url', 'setting_value' => INSTAGRAM_URL],
            ['setting_key' => 'facebook_url', 'setting_value' => FACEBOOK_URL]
        ];
        
        $stmt = $pdo->prepare("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (?, ?)");
        foreach ($settings as $setting) {
            $stmt->execute([$setting['setting_key'], $setting['setting_value']]);
        }
        $success[] = 'Configurações padrão inseridas';
        
    } catch (PDOException $e) {
        $errors[] = 'Erro na conexão com o banco de dados: ' . $e->getMessage();
    }
}

// Create .htaccess if it doesn't exist
if (!file_exists('.htaccess')) {
    $htaccess = '# LL Magazine - Apache Configuration
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options SAMEORIGIN
    Header always set X-XSS-Protection "1; mode=block"
</IfModule>

<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>

<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/javascript
</IfModule>
';
    
    if (file_put_contents('.htaccess', $htaccess)) {
        $success[] = 'Arquivo .htaccess criado com sucesso';
    } else {
        $errors[] = 'Não foi possível criar o arquivo .htaccess';
    }
}

// Create installed.lock file
if (empty($errors)) {
    if (file_put_contents('installed.lock', date('Y-m-d H:i:s'))) {
        $success[] = 'Instalação concluída com sucesso!';
    } else {
        $errors[] = 'Não foi possível criar o arquivo de controle de instalação';
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalação - LL Magazine</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #dc2626;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border: 1px solid #f5c6cb;
        }
        
        .btn {
            background-color: #dc2626;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
        }
        
        .btn:hover {
            background-color: #b91c1c;
        }
        
        .requirements {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        .requirements h3 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .requirements ul {
            list-style-type: none;
            padding: 0;
        }
        
        .requirements li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        
        .requirements li:before {
            content: "✓ ";
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Instalação - LL Magazine</h1>
        
        <?php if (!empty($errors)): ?>
            <h2>❌ Erros encontrados:</h2>
            <?php foreach ($errors as $error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <h2>✅ Sucessos:</h2>
            <?php foreach ($success as $msg): ?>
                <div class="success"><?php echo htmlspecialchars($msg); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <div class="requirements">
            <h3>📋 Requisitos do Sistema:</h3>
            <ul>
                <li>PHP 7.4 ou superior</li>
                <li>Extensão PDO MySQL</li>
                <li>Extensão JSON</li>
                <li>Extensão cURL</li>
                <li>Extensão mbstring</li>
                <li>Permissões de escrita nos diretórios</li>
                <li>Conexão com banco de dados MySQL</li>
            </ul>
        </div>
        
        <?php if (empty($errors)): ?>
            <div style="text-align: center;">
                <a href="index.html" class="btn">🎉 Acessar o Site</a>
            </div>
            
            <div style="background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin-top: 20px;">
                <strong>⚠️ Importante:</strong>
                <ul style="margin: 10px 0;">
                    <li>Configure o número do WhatsApp no arquivo <code>config.php</code></li>
                    <li>Adicione as imagens dos produtos na pasta <code>assets/images/products/</code></li>
                    <li>Teste todas as funcionalidades antes de colocar em produção</li>
                    <li>Remova este arquivo de instalação após a configuração</li>
                </ul>
            </div>
        <?php else: ?>
            <div style="text-align: center;">
                <a href="install.php" class="btn">🔄 Tentar Novamente</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
