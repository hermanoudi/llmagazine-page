#!/bin/bash

echo "🚀 Configurando Apache para LL Magazine"
echo "========================================"

# Verificar se está rodando como root
if [ "$EUID" -ne 0 ]; then
    echo "❌ Este script precisa ser executado com sudo"
    echo "Execute: sudo ./setup-apache.sh"
    exit 1
fi

# 1. Copiar arquivo de configuração
echo "📁 Copiando arquivo de configuração..."
cp /home/hermano/projetos/llmagazine-page/ll-magazine.conf /etc/apache2/sites-available/

# 2. Habilitar o site
echo "🔧 Habilitando o site..."
a2ensite ll-magazine.conf

# 3. Recarregar Apache
echo "🔄 Recarregando Apache..."
systemctl reload apache2

# 4. Adicionar ao hosts
echo "🌐 Adicionando ao /etc/hosts..."
if ! grep -q "ll-magazine.local" /etc/hosts; then
    echo "127.0.0.1 ll-magazine.local" >> /etc/hosts
    echo "✅ Adicionado ao /etc/hosts"
else
    echo "⚠️  Já existe no /etc/hosts"
fi

# 5. Testar configuração
echo "🧪 Testando configuração..."
if apache2ctl configtest; then
    echo "✅ Configuração do Apache está correta"
else
    echo "❌ Erro na configuração do Apache"
    exit 1
fi

echo ""
echo "🎉 Configuração concluída!"
echo "========================="
echo "🌐 Acesse: http://ll-magazine.local"
echo "📱 API: http://ll-magazine.local/api/products.php"
echo "⚙️  Instalação: http://ll-magazine.local/install.php"
echo ""
echo "🔍 Para testar:"
echo "curl -I http://ll-magazine.local"
