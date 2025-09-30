<?php
// LL Magazine - Local Development Server
// Script para rodar o site localmente com PHP

// Change to the project directory
chdir(__DIR__);

// Start the built-in PHP server
echo "🚀 LL Magazine - Servidor Local\n";
echo "================================\n";
echo "📱 Site: http://localhost:8080\n";
echo "🔧 API: http://localhost:8080/api/products.php\n";
echo "⚙️  Instalação: http://localhost:8080/install.php\n";
echo "================================\n";
echo "Pressione Ctrl+C para parar o servidor\n\n";

// Start server
exec('php -S localhost:8080 -t .');
?>
