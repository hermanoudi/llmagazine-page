# LL Magazine - Vitrine Virtual

Site responsivo para vitrine virtual de loja de roupas, desenvolvido com HTML5, CSS3, JavaScript e PHP.

## 🎯 Características

- **Design Responsivo**: Adaptável a todos os dispositivos (mobile, tablet, desktop)
- **Identidade Visual**: Cores vermelha e branca conforme solicitado
- **Integração WhatsApp**: Botões de compra direcionam para WhatsApp
- **Vitrine Virtual**: Foco em apresentação de produtos, não e-commerce
- **Otimizado para Hostinger**: Configurações específicas para Single Web Hosting

## 🚀 Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Hospedagem**: Hostinger (Single Web Hosting) com HTTPS
- **Ícones**: Font Awesome 6.0
- **Fontes**: Google Fonts (Inter)

## 📁 Estrutura do Projeto

```
ll-magazine/
├── index.html              # Página principal
├── config.php             # Configurações e conexão BD
├── .env.example           # Template de variáveis de ambiente
├── .htaccess              # Configurações Apache
├── 404.html               # Página de erro 404
├── 500.html               # Página de erro 500
├── README.md              # Documentação
├── admin/                 # Painel Administrativo
│   ├── index.html         # Dashboard do admin
│   ├── login.html         # Tela de login
│   ├── css/
│   │   └── admin.css      # Estilos do painel admin
│   └── js/
│       ├── admin.js       # Lógica do painel admin
│       └── login.js       # Lógica de autenticação
├── assets/
│   ├── css/
│   │   └── style.css      # Estilos principais
│   ├── js/
│   │   ├── script.js      # JavaScript principal
│   │   └── color-mapping.js # Mapeamento de cores
│   └── images/
│       ├── products/      # Imagens dos produtos
│       └── hero-model.jpg # Imagem do banner
├── api/
│   ├── products.php       # API pública de produtos
│   ├── auth.php           # API de autenticação
│   ├── JWT.php            # Gerenciamento de tokens JWT
│   └── admin/
│       ├── products.php   # CRUD de produtos (protegido)
│       └── upload.php     # Upload de imagens (protegido)
├── database/
│   ├── schema.sql         # Estrutura do banco
│   ├── seed.sql           # Dados iniciais
│   ├── admin_schema.sql   # Tabela de usuários admin
│   └── setup.sh           # Script de setup automático
└── docs/
    ├── install_to_hostinger.md  # Guia de deploy
    └── admin_guide.md           # Guia do painel admin
```

## 📋 Requisitos do Sistema

### Desenvolvimento Local
- **PHP**: 7.4 ou superior
- **MySQL**: 5.7+ ou superior
- **Extensões PHP**: PDO, pdo_mysql, mysqli, json, mbstring
- **Python**: 3.6+ (para gerar imagens)
- **PIL/Pillow**: Para processamento de imagens
- **Apache**: 2.4+ (opcional, para ambiente de produção)

### Produção (Hostinger)
- **PHP**: 7.4 ou superior
- **MySQL**: 5.7+ ou superior
- **Extensões PHP**: PDO, pdo_mysql habilitadas
- **HTTPS**: Certificado SSL (incluso no plano)

### Instalação de Dependências

```bash
# Ubuntu/Debian
sudo apt update
sudo apt install php php-cli php-mysql php-mbstring mysql-server python3 python3-pip apache2

# Instalar Pillow para Python
pip3 install Pillow

# Verificar instalação
php -v
php -m | grep -i mysql  # Deve mostrar pdo_mysql, mysqli, mysqlnd
python3 --version
```

## 🛠️ Instalação e Configuração

### 1. Configurar Ambiente

**Passo 1: Copiar arquivo de configuração**
```bash
cp .env.example .env
```

**Passo 2: Editar `.env` com suas credenciais**
```env
DB_HOST=localhost
DB_NAME=ll_magazine_db
DB_USER=root
DB_PASS=sua_senha_mysql
WHATSAPP_NUMBER=5534991738581
```

**Passo 3: Criar banco de dados**
```bash
# Opção automática (recomendado)
./database/setup.sh

# Opção manual
mysql -u root -p
CREATE DATABASE ll_magazine_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ll_magazine_db;
SOURCE database/schema.sql;
SOURCE database/seed.sql;
SOURCE database/admin_schema.sql;
EXIT;
```

**Credenciais padrão do admin:**
- **Usuário:** `admin`
- **Senha:** `admin123`
- **⚠️ IMPORTANTE:** Altere a senha após o primeiro login!

### 2. Desenvolvimento Local

#### Opção A: Servidor PHP Embutido (Recomendado para desenvolvimento)

```bash
# Clone ou baixe o projeto
cd ll-magazine

# Inicie o servidor PHP
php -S localhost:8080

# Acesse no navegador
# Site: http://localhost:8080
# Painel Admin: http://localhost:8080/admin/login.html
# API: http://localhost:8080/api/products.php
```

#### Opção B: Apache (Para ambiente mais próximo da produção)

**Pré-requisitos:**
- Apache 2.4+
- PHP 7.4+
- Módulo mod_rewrite habilitado

**Configuração rápida:**
```bash
# Execute o script de configuração
sudo ./setup-apache.sh

# Acesse no navegador
# Site: http://ll-magazine.local
# API: http://ll-magazine.local/api/products.php
```

**Configuração manual:**
```bash
# 1. Copiar configuração
sudo cp ll-magazine.conf /etc/apache2/sites-available/

# 2. Habilitar site
sudo a2ensite ll-magazine.conf

# 3. Recarregar Apache
sudo systemctl reload apache2

# 4. Adicionar ao hosts
echo '127.0.0.1 ll-magazine.local' | sudo tee -a /etc/hosts
```

### 2. Upload para Hostinger

1. Faça upload de todos os arquivos para o diretório `public_html` do seu domínio
2. Certifique-se de que o PHP está habilitado (versão 7.4 ou superior) no hPanel

### 3. Configuração do WhatsApp

Edite o arquivo `assets/js/script.js` e altere o número do WhatsApp:

```javascript
const CONFIG = {
    whatsappNumber: '5511999999999', // Substitua pelo seu número
    // ...
};
```

### 4. Configuração do Banco de Dados (Opcional)

Para usar banco de dados em produção, edite `api/products.php`:

```php
$host = 'localhost';
$dbname = 'seu_banco_de_dados';
$username = 'seu_usuario';
$password = 'sua_senha';
```

### 5. Imagens dos Produtos

Adicione as imagens dos produtos na pasta `assets/images/products/` com os nomes:
- `conjunto-black.jpg`
- `conjunto-prime-listras.jpg`
- `conjunto-corvette.jpg`
- `vestido-floral.jpg`
- `blusa-branca.jpg`
- `short-jeans.jpg`
- `camisa-vermelha.jpg`
- `vestido-longo.jpg`

## 🎨 Personalização

### Cores
As cores principais estão definidas no CSS:
- **Vermelho**: `#dc2626`
- **Branco**: `#ffffff`
- **Vermelho escuro**: `#b91c1c`

### Produtos
Edite o array `$products` em `api/products.php` para adicionar/remover produtos.

### Categorias
Modifique o array `$categories` em `api/products.php` para alterar as categorias.

## 📱 Funcionalidades

### Frontend (Vitrine)
- ✅ Design responsivo
- ✅ Menu mobile
- ✅ Carrossel de imagens com produtos em destaque
- ✅ Filtro por categorias
- ✅ Modal de detalhes do produto
- ✅ Integração WhatsApp
- ✅ Lazy loading de imagens
- ✅ Animações suaves

### Painel Administrativo
- ✅ **Autenticação JWT** - Login seguro com tokens
- ✅ **Gerenciamento de Produtos** - CRUD completo
- ✅ **Upload de Imagens** - Upload direto pelo painel (JPG, PNG, GIF, WEBP, AVIF)
- ✅ **Sistema de Cores** - Nomes de cores em português (50+ cores)
- ✅ **Produtos em Destaque** - Exibidos no carrossel hero
- ✅ **Categorização** - Looks, Masculino, Feminino, Infantil, Presentes
- ✅ **Controle de Estoque** - Marcar produtos como disponíveis/esgotados
- ✅ **Descontos** - Sistema de preço original e desconto
- ✅ **Alteração de Senha** - Trocar senha do administrador
- ✅ **Interface Intuitiva** - Design moderno e fácil de usar

### Backend (API)
- ✅ **API REST** para produtos
- ✅ **API de Autenticação** com JWT
- ✅ **Upload de Arquivos** com validação
- ✅ **CRUD Protegido** por autenticação
- ✅ Filtros por categoria
- ✅ Rate limiting
- ✅ Headers de segurança
- ✅ Logs de erro
- ✅ CORS habilitado
- ✅ Sanitização de inputs

## 🔒 Segurança

- Headers de segurança configurados
- Sanitização de inputs
- Rate limiting implementado
- Proteção contra hotlinking
- Bloqueio de arquivos sensíveis

## 📊 Performance

- Compressão Gzip habilitada
- Cache de assets configurado
- Lazy loading de imagens
- Minificação CSS/JS (recomendado para produção)

## 🌐 SEO

- Meta tags otimizadas
- Estrutura semântica HTML5
- URLs amigáveis
- Sitemap.xml (recomendado)

## 🔧 Scripts e Ferramentas

### Scripts Disponíveis

- `setup-apache.sh` - Configuração automática do Apache
- `test-local.sh` - Teste de conectividade local
- `create_images.py` - Geração de imagens placeholder
- `install.php` - Instalação e configuração do banco de dados

### Comandos Úteis

```bash
# Testar conectividade
./test-local.sh

# Verificar status do Apache
systemctl status apache2

# Ver logs do Apache
sudo tail -f /var/log/apache2/error.log

# Verificar configuração do Apache
sudo apache2ctl configtest

# Recriar imagens
python3 create_images.py
```

## 🐛 Troubleshooting

### Problemas Comuns

**1. Erro "Database connection failed" ou "could not find driver":**
```bash
# Verificar se extensão MySQL está instalada
php -m | grep -i mysql

# Se não aparecer pdo_mysql, instalar:
sudo apt install php-mysql

# Reiniciar servidor PHP
pkill -f "php -S"
php -S localhost:8080
```

**2. Produtos não aparecem na página:**
```bash
# Verificar se banco existe e tem dados
mysql -u root -p -e "USE ll_magazine_db; SELECT COUNT(*) FROM products;"

# Verificar se .env está configurado corretamente
cat .env | grep DB_

# Testar API diretamente
curl http://localhost:8080/api/products.php
```

**3. Imagens não carregam:**
```bash
# Verificar se as imagens existem
ls -la assets/images/products/

# Recriar imagens
python3 create_images.py
```

**2. Apache não serve o site:**
```bash
# Verificar se o site está habilitado
sudo a2ensite ll-magazine.conf

# Recarregar Apache
sudo systemctl reload apache2

# Verificar logs
sudo tail -f /var/log/apache2/error.log
```

**3. Erro 404 no ll-magazine.local:**
```bash
# Verificar se está no /etc/hosts
grep ll-magazine.local /etc/hosts

# Adicionar se não existir
echo '127.0.0.1 ll-magazine.local' | sudo tee -a /etc/hosts
```

**4. Erro de permissão:**
```bash
# Corrigir permissões
chmod -R 755 assets/
chmod -R 755 api/
```

**5. PHP não executa:**
```bash
# Verificar se PHP está instalado
php -v

# Instalar se necessário (Ubuntu/Debian)
sudo apt update && sudo apt install php php-cli
```

## 📞 Suporte

Para dúvidas ou suporte, entre em contato através do WhatsApp configurado no site.

## 📄 Licença

Este projeto foi desenvolvido especificamente para a LL Magazine.

---

**Desenvolvido com ❤️ para LL Magazine**
