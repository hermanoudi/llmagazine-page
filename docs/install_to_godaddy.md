# Guia de Deploy no GoDaddy

Este documento fornece instruções passo a passo para fazer o deploy do site LL Magazine na hospedagem GoDaddy.

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter:

- [ ] Conta GoDaddy ativa com hospedagem contratada
- [ ] Acesso ao cPanel da GoDaddy
- [ ] Domínio configurado e apontando para o servidor GoDaddy
- [ ] Certificado SSL ativo (HTTPS)
- [ ] Cliente FTP (FileZilla, WinSCP, ou similar) ou acesso via File Manager do cPanel
- [ ] MySQL Database disponível no plano de hospedagem

## 🗄️ Passo 1: Criar o Banco de Dados MySQL

### 1.1 Acessar o MySQL Databases no cPanel

1. Faça login no **cPanel** da GoDaddy
2. Localize e clique em **"MySQL Databases"** ou **"Bancos de Dados MySQL"**

### 1.2 Criar Novo Banco de Dados

1. Na seção **"Create New Database"**:
   - Nome do banco: `ll_magazine_db` (ou outro nome de sua preferência)
   - Clique em **"Create Database"**
   - Anote o nome completo do banco (geralmente é prefixado com seu usuário, ex: `usuario_ll_magazine_db`)

### 1.3 Criar Usuário do Banco de Dados

1. Na seção **"MySQL Users"**:
   - Username: `ll_magazine_user` (ou outro nome)
   - Password: Crie uma senha forte e **anote-a**
   - Clique em **"Create User"**

### 1.4 Adicionar Usuário ao Banco

1. Na seção **"Add User to Database"**:
   - Selecione o usuário criado
   - Selecione o banco de dados criado
   - Clique em **"Add"**
   - Marque **"ALL PRIVILEGES"** (Todos os Privilégios)
   - Clique em **"Make Changes"**

### 1.5 Importar Schema e Dados

1. No cPanel, acesse **"phpMyAdmin"**
2. Selecione o banco de dados criado no menu lateral esquerdo
3. Clique na aba **"Import"** (Importar)
4. Importe os seguintes arquivos **nesta ordem**:
   - `database/schema.sql` - Cria tabelas de produtos e categorias
   - `database/seed.sql` - Insere produtos de exemplo
   - `database/admin_schema.sql` - **NOVO** Cria tabela de usuários admin
5. Para cada arquivo:
   - Clique em **"Choose File"** e selecione o arquivo
   - Clique em **"Go"** (Executar)
   - Aguarde a confirmação de sucesso

**Alternativa via Terminal SSH (se disponível):**
```bash
mysql -u usuario_ll_magazine_user -p usuario_ll_magazine_db < database/schema.sql
mysql -u usuario_ll_magazine_user -p usuario_ll_magazine_db < database/seed.sql
mysql -u usuario_ll_magazine_user -p usuario_ll_magazine_db < database/admin_schema.sql
```

**Credenciais padrão do Painel Admin:**
- **Usuário:** `admin`
- **Senha:** `admin123`
- **⚠️ IMPORTANTE:** Altere a senha após o primeiro acesso!

## 📁 Passo 2: Upload dos Arquivos

### 2.1 Preparar os Arquivos Localmente

**Importante:** NÃO faça upload do arquivo `.env`! Ele será criado diretamente no servidor.

Arquivos/pastas para fazer upload:
```
✅ admin/            - **NOVO** Painel administrativo
✅ api/              - APIs públicas e privadas
✅ assets/           - CSS, JS, imagens
✅ database/         - Scripts SQL (opcional)
✅ docs/             - Documentação (opcional)
✅ 404.html
✅ 500.html
✅ config.php        - **NOVO** Configurações do sistema
✅ index.html
✅ .htaccess         - Regras do Apache (se existir)
✅ .env.example      - Template de variáveis
❌ .env              - NÃO fazer upload - criar no servidor
❌ .git/             - NÃO fazer upload
❌ logs/             - NÃO fazer upload
```

### 2.2 Fazer Upload via FTP

**Usando FileZilla ou similar:**

1. Conecte-se ao servidor FTP da GoDaddy:
   - Host: Seu domínio ou IP do servidor
   - Usuário: Seu usuário FTP (fornecido pela GoDaddy)
   - Senha: Sua senha FTP
   - Porta: 21 (ou 22 para SFTP)

2. Navegue até a pasta `public_html/` no servidor

3. Faça upload de todos os arquivos do projeto (exceto `.env` e `.git/`)

**Usando File Manager do cPanel:**

1. Acesse **"File Manager"** no cPanel
2. Navegue até `public_html/`
3. Clique em **"Upload"**
4. Selecione e envie todos os arquivos necessários
5. Se fizer upload de um .zip:
   - Clique com botão direito no arquivo .zip
   - Selecione **"Extract"**
   - Exclua o arquivo .zip após extrair

### 2.3 Verificar Permissões

Certifique-se de que as permissões estão corretas:

```
Pastas: 755
Arquivos: 644
assets/images/products/: 775 (permitir upload pelo painel admin)
```

No File Manager:
1. Selecione pastas → Botão direito → **"Change Permissions"** → `755`
2. Selecione arquivos PHP/HTML → Botão direito → **"Change Permissions"** → `644`
3. **IMPORTANTE:** `assets/images/products/` → **"Change Permissions"** → `775`
   - Isso permite que o painel admin faça upload de imagens

## 🔐 Passo 3: Configurar Variáveis de Ambiente

### 3.1 Criar arquivo .env no servidor

1. No **File Manager** do cPanel, navegue até `public_html/`
2. Clique em **"+ File"** (Novo Arquivo)
3. Nome do arquivo: `.env`
4. Clique com botão direito no `.env` → **"Edit"**

### 3.2 Adicionar Configurações

Cole o seguinte conteúdo no arquivo `.env` (ajuste os valores):

```env
# Database Configuration
DB_HOST=localhost
DB_NAME=usuario_ll_magazine_db
DB_USER=usuario_ll_magazine_user
DB_PASS=SuaSenhaDoBanco123

# WhatsApp Configuration
WHATSAPP_NUMBER=5534991738581
WHATSAPP_MESSAGE=Olá! Gostaria de saber mais sobre este produto da LL Magazine:

# Site Configuration
SITE_NAME=LL Magazine
SITE_URL=https://seudominio.com.br
SITE_EMAIL=contato@seudominio.com.br

# Environment
APP_ENV=production
```

**Importante:**
- Substitua `usuario_ll_magazine_db`, `usuario_ll_magazine_user` e `SuaSenhaDoBanco123` pelos valores reais criados no Passo 1
- Altere `SITE_URL` para seu domínio real
- Altere `WHATSAPP_NUMBER` para o número de WhatsApp Business da loja
- Defina `APP_ENV=production` para ambiente de produção

### 3.3 Proteger o arquivo .env

Crie ou edite o arquivo `.htaccess` na raiz do `public_html/`:

```apache
# Bloquear acesso ao arquivo .env
<Files .env>
    Order allow,deny
    Deny from all
</Files>

# Bloquear acesso a arquivos sensíveis
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>
```

## ⚙️ Passo 4: Configurar PHP

### 4.1 Verificar Versão do PHP

1. No cPanel, acesse **"Select PHP Version"** ou **"MultiPHP Manager"**
2. Certifique-se de que está usando **PHP 7.4 ou superior**
3. Se necessário, altere a versão

### 4.2 Habilitar Extensões PHP Necessárias ⚠️ IMPORTANTE

No **"Select PHP Version"**, clique em **"PHP Extensions"** ou **"Extensions"**:

**Marque as seguintes extensões (OBRIGATÓRIAS para o sistema funcionar):**
- ✅ `pdo` - **Obrigatório** para conexão com banco de dados
- ✅ `pdo_mysql` - **Obrigatório** para MySQL via PDO
- ✅ `mysqli` - **Obrigatório** para MySQL
- ✅ `mysqlnd` - **Obrigatório** driver MySQL nativo
- ✅ `json` - **Obrigatório** para API JSON
- ✅ `mbstring` - **Obrigatório** para strings multibyte

Clique em **"Save"** ou **"Apply"**

**⚠️ Atenção:** Se `pdo_mysql` não estiver habilitado, os produtos NÃO aparecerão no site!

## 🔒 Passo 5: Configurar SSL/HTTPS

### 5.1 Ativar SSL

1. No cPanel, acesse **"SSL/TLS Status"**
2. Certifique-se de que o SSL está ativo para seu domínio
3. Se não estiver, clique em **"Run AutoSSL"**

### 5.2 Forçar HTTPS (Redirecionar HTTP → HTTPS)

Edite o arquivo `.htaccess` e adicione no **início do arquivo**:

```apache
# Forçar HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## ✅ Passo 6: Testar a Instalação

### 6.1 Testar o Site

1. Acesse seu domínio: `https://seudominio.com.br`
2. Verifique se a página principal carrega corretamente
3. Teste se os produtos aparecem (vindos do banco de dados)
4. Teste o filtro de categorias
5. Teste o botão de compra pelo WhatsApp

### 6.2 Testar o Painel Administrativo

1. Acesse: `https://seudominio.com.br/admin/login.html`
2. Faça login com as credenciais padrão:
   - **Usuário:** `admin`
   - **Senha:** `admin123`
3. Teste as funcionalidades:
   - ✅ Visualizar lista de produtos
   - ✅ Criar novo produto (com upload de imagem)
   - ✅ Editar produto existente
   - ✅ Marcar produto como destaque
   - ✅ Excluir produto
   - ✅ Alterar senha nas configurações
4. **IMPORTANTE:** Altere a senha padrão em **Configurações** → **Alterar Senha**

### 6.3 Testar a API

Acesse diretamente os endpoints da API:

- `https://seudominio.com.br/api/products.php` - Deve retornar JSON com produtos
- `https://seudominio.com.br/api/products.php?config=1` - Deve retornar configuração do WhatsApp
- `https://seudominio.com.br/api/products.php?category=feminino` - Deve filtrar produtos

### 6.3 Verificar Logs de Erro

Se algo não funcionar:

1. No cPanel, acesse **"Errors"** ou **"Error Log"**
2. Verifique os últimos erros do Apache/PHP
3. Ou verifique o arquivo `/logs/error.log` criado pelo sistema

## 🐛 Solução de Problemas

### Erro: "Database connection failed"

**Causa:** Credenciais incorretas no `.env` ou extensão PHP MySQL não habilitada

**Solução:**
1. Verifique se `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` estão corretos no `.env`
2. Confirme que o usuário tem permissões no banco de dados
3. Verifique se o nome do banco inclui o prefixo do usuário (ex: `usuario_ll_magazine_db`)
4. **Verifique se extensão MySQL está habilitada** (veja Passo 4.2)

### Erro: "500 Internal Server Error"

**Causa:** Erro de PHP ou permissões incorretas

**Solução:**
1. Verifique permissões: pastas `755`, arquivos `644`
2. Verifique o **Error Log** do cPanel
3. Certifique-se de que o arquivo `.env` existe e está configurado corretamente
4. Verifique se a versão do PHP é 7.4+

### Produtos não aparecem

**Causa:** Banco de dados vazio ou API não conecta

**Solução:**
1. Acesse phpMyAdmin e verifique se as tabelas `products` e `categories` existem
2. Verifique se há dados nas tabelas
3. Reimporte `database/seed.sql` se necessário
4. Teste a API diretamente: `https://seudominio.com.br/api/products.php`

### WhatsApp não funciona

**Causa:** Número não configurado ou formato incorreto

**Solução:**
1. Verifique o `.env` → `WHATSAPP_NUMBER`
2. Formato correto: `5534991738581` (código país + DDD + número, sem espaços ou caracteres especiais)
3. Teste a API de config: `https://seudominio.com.br/api/products.php?config=1`

### Imagens não carregam

**Causa:** Arquivos de imagem não foram enviados ou caminhos incorretos

**Solução:**
1. Verifique se a pasta `assets/images/products/` existe no servidor
2. Faça upload das imagens dos produtos
3. Nomes devem corresponder exatamente aos registrados no banco de dados
4. Execute `python3 create_images.py` localmente e faça upload das imagens geradas

### Erro: ".env file not found"

**Causa:** Arquivo `.env` não foi criado no servidor

**Solução:**
1. Crie o arquivo `.env` no File Manager conforme Passo 3
2. Certifique-se de que está na raiz do `public_html/`
3. Verifique se o nome está correto: `.env` (com ponto no início)

### Erro: "could not find driver" nos logs

**Causa:** Extensão PDO MySQL não está habilitada no PHP

**Solução:**
1. Acesse **"Select PHP Version"** ou **"MultiPHP Manager"** no cPanel
2. Clique em **"PHP Extensions"** ou **"Extensions"**
3. Certifique-se de que as seguintes extensões estão **marcadas/habilitadas**:
   - ✅ `pdo`
   - ✅ `pdo_mysql`
   - ✅ `mysqli`
   - ✅ `mysqlnd`
4. Clique em **"Save"** ou **"Apply"**
5. Aguarde alguns segundos e teste novamente o site
6. Se o problema persistir, entre em contato com o suporte da GoDaddy

## 📊 Pós-Deploy

### Manutenção Regular

- **Backup do Banco de Dados:** Use phpMyAdmin → Export regularmente
- **Backup dos Arquivos:** Baixe via FTP periodicamente
- **Monitorar Logs:** Verifique `/logs/error.log` semanalmente
- **Atualizar Produtos:** Use phpMyAdmin para adicionar/editar produtos

### Adicionar Novos Produtos

**✨ Via Painel Admin (Recomendado):**

1. Acesse: `https://seudominio.com.br/admin/`
2. Faça login
3. Clique em **"Novo Produto"**
4. Preencha o formulário:
   - **Nome do Produto**
   - **Categoria** (selecione do dropdown)
   - **Preço** (formato: 99,90)
   - **Preço Original** e **Desconto** (opcional)
   - **Imagem** - Clique em "Escolher Arquivo" e faça upload direto
   - **Descrição**
   - **Cores** - Digite nomes em português: `Vermelho, Azul, Branco`
   - **Tamanhos** - Exemplo: `PP, P, M, G, GG`
   - **Em Estoque** - Marque se disponível
   - **Produto em Destaque** - Marque para aparecer no carrossel hero
5. Clique em **"Salvar Produto"**

**Cores disponíveis:** Preto, Branco, Vermelho, Azul, Verde, Amarelo, Rosa, Laranja, Roxo, Marrom, Nude, Coral, Vinho, Bordô, Dourado, Prateado, Bronze, e muitas outras!

**Via phpMyAdmin (Método Alternativo):**

1. Acesse phpMyAdmin no cPanel
2. Selecione o banco de dados
3. Clique na tabela `products`
4. Clique em **"Insert"** (Inserir)
5. Preencha os campos:
   - `name`: Nome do produto
   - `category`: Uma das categorias (`looks`, `feminino`, `masculino`, `infantil`, `presentes`)
   - `price`: Formato `"99,90"`
   - `original_price`: Preço original ou `NULL`
   - `discount`: Porcentagem ou `NULL`
   - `image`: Caminho da imagem
   - `description`: Descrição do produto
   - `colors`: `["#FF0000", "#00FF00"]` (formato JSON com códigos hex)
   - `sizes`: `["P", "M", "G"]` (formato JSON)
   - `in_stock`: `1` (em estoque) ou `0` (fora de estoque)
   - `featured`: `1` (destaque) ou `0` (normal)

### Alterar Número do WhatsApp

1. Edite o arquivo `.env` no servidor
2. Altere `WHATSAPP_NUMBER=5534991738581` para o novo número
3. Salve o arquivo
4. Limpe o cache do navegador e teste

## 📞 Suporte GoDaddy

Se precisar de ajuda técnica da GoDaddy:

- **Chat Online:** Disponível no painel da GoDaddy
- **Telefone:** 0800 721 8360 (Brasil)
- **Documentação:** https://br.godaddy.com/help

## ✨ Checklist Final

Antes de considerar o deploy completo, verifique:

### Backend
- [ ] Banco de dados criado e populado (schema.sql + seed.sql + admin_schema.sql)
- [ ] Arquivos enviados para `public_html/`
- [ ] Arquivo `.env` criado e configurado com credenciais corretas
- [ ] PHP 7.4+ ativo
- [ ] **Extensões PHP habilitadas** (pdo, pdo_mysql, mysqli, mysqlnd, json, mbstring)
- [ ] Permissões corretas (`assets/images/products/` = 775)
- [ ] SSL/HTTPS ativo e forçado

### Vitrine (Frontend)
- [ ] Site acessível via HTTPS
- [ ] **Produtos carregando do banco de dados** (verificar API: /api/products.php)
- [ ] Filtros de categoria funcionando
- [ ] Botão WhatsApp redirecionando corretamente
- [ ] Imagens dos produtos carregando
- [ ] Modal de produtos funcionando
- [ ] Produtos em destaque aparecendo no carrossel hero
- [ ] Responsividade testada (mobile/desktop)

### Painel Admin
- [ ] Login acessível (`/admin/login.html`)
- [ ] Login funcionando com credenciais padrão
- [ ] **Senha padrão alterada** (admin123 → nova senha segura)
- [ ] Lista de produtos carregando
- [ ] Criar produto funcionando
- [ ] **Upload de imagem funcionando**
- [ ] Editar produto funcionando
- [ ] Excluir produto funcionando
- [ ] Sistema de cores (nomes em português) funcionando
- [ ] Marcar produto como destaque funcionando
- [ ] Alteração de senha funcionando

### Geral
- [ ] Sem erros no Error Log do cPanel
- [ ] Backup inicial criado (banco de dados + arquivos)

---

**Parabéns! Seu site LL Magazine está no ar! 🎉**
