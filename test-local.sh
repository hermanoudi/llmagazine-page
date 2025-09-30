#!/bin/bash

echo "🚀 LL Magazine - Teste Local"
echo "=============================="

# Verificar se o PHP está instalado
if ! command -v php &> /dev/null; then
    echo "❌ PHP não está instalado"
    exit 1
fi

echo "✅ PHP encontrado: $(php -v | head -1)"

# Verificar se o Apache está rodando
if systemctl is-active --quiet apache2; then
    echo "✅ Apache está rodando"
else
    echo "❌ Apache não está rodando"
    echo "Tentando iniciar o Apache..."
    sudo systemctl start apache2
fi

# Verificar se o módulo userdir está habilitado
if [ -f "/etc/apache2/mods-enabled/userdir.conf" ]; then
    echo "✅ Módulo userdir está habilitado"
else
    echo "⚠️  Módulo userdir não está habilitado"
    echo "Execute: sudo a2enmod userdir && sudo systemctl reload apache2"
fi

echo ""
echo "🌐 URLs para testar:"
echo "==================="
echo "1. Site principal: http://localhost/~hermano/ll-magazine/"
echo "2. API de produtos: http://localhost/~hermano/ll-magazine/api/products.php"
echo "3. Instalação: http://localhost/~hermano/ll-magazine/install.php"
echo ""
echo "📱 Ou use o servidor PHP embutido:"
echo "php -S localhost:8080"
echo ""

# Testar se o site está acessível
echo "🔍 Testando conectividade..."
if curl -s -o /dev/null -w "%{http_code}" http://localhost/~hermano/ll-magazine/ | grep -q "200"; then
    echo "✅ Site acessível via Apache"
else
    echo "❌ Site não acessível via Apache"
    echo "💡 Use o servidor PHP embutido: php -S localhost:8080"
fi
