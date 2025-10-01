# Guia do Painel Administrativo - LL Magazine

Este documento descreve como usar o painel administrativo para gerenciar produtos do site LL Magazine.

## 📋 Índice

1. [Acesso ao Painel](#acesso-ao-painel)
2. [Gerenciar Produtos](#gerenciar-produtos)
3. [Configurações](#configurações)
4. [Solução de Problemas](#solução-de-problemas)

---

## 🔐 Acesso ao Painel

### URL de Acesso

**Local:** `http://localhost:8080/admin/login.html`
**Produção:** `https://seudominio.com.br/admin/login.html`

### Credenciais Padrão

**Usuário:** `admin`
**Senha:** `admin123`

⚠️ **IMPORTANTE:** Altere a senha após o primeiro login por segurança!

### Primeiro Acesso

1. Acesse a URL do painel admin
2. Digite as credenciais padrão
3. Clique em "Entrar"
4. Após entrar, vá em "Configurações"
5. Altere sua senha

---

## 📦 Gerenciar Produtos

### Visualizar Produtos

Na tela principal do dashboard, você verá uma tabela com todos os produtos cadastrados:

- **ID**: Número único do produto
- **Imagem**: Miniatura do produto
- **Nome**: Nome do produto
- **Categoria**: Looks, Feminino, Masculino, Infantil ou Presentes
- **Preço**: Preço de venda
- **Estoque**: Status (Em estoque / Esgotado)
- **Destaque**: Se o produto aparece em destaque (⭐)
- **Ações**: Botões para Editar e Excluir

### Adicionar Novo Produto

1. Clique no botão **"+ Novo Produto"** no canto superior direito
2. Preencha os campos obrigatórios:

#### Campos Obrigatórios (*)

- **Nome do Produto**: Nome que aparecerá no site
- **Categoria**: Selecione uma categoria
  - Looks
  - Masculino
  - Feminino
  - Infantil
  - Presentes
- **Preço**: Formato `99,90` (com vírgula)
- **Caminho da Imagem**: Caminho relativo da imagem
  - Exemplo: `assets/images/products/vestido-azul.jpg`
- **Descrição**: Descrição do produto (aparece no modal de detalhes)

#### Campos Opcionais

- **Preço Original**: Se houver desconto, informe o preço original
- **Desconto (%)**: Percentual de desconto (0-100)
- **Cores**: Códigos hexadecimais separados por vírgula
  - Exemplo: `#FF0000, #00FF00, #0000FF`
- **Tamanhos**: Separados por vírgula
  - Padrão: `PP, P, M, G, GG`
- **Em Estoque**: Marque se o produto está disponível
- **Produto em Destaque**: Marque para destacar na página inicial

3. Clique em **"Salvar Produto"**

### Editar Produto

1. Localize o produto na tabela
2. Clique no botão de editar (ícone de lápis)
3. Modifique os campos desejados
4. Clique em **"Salvar Produto"**

### Excluir Produto

1. Localize o produto na tabela
2. Clique no botão de excluir (ícone de lixeira)
3. Confirme a exclusão

⚠️ **ATENÇÃO:** Esta ação não pode ser desfeita!

---

## ⚙️ Configurações

### Alterar Senha

1. Clique em "Configurações" no menu lateral
2. Preencha os campos:
   - **Senha Atual**: Sua senha atual
   - **Nova Senha**: Nova senha (mínimo 6 caracteres)
   - **Confirmar Nova Senha**: Digite novamente a nova senha
3. Clique em **"Alterar Senha"**

---

## 🖼️ Gerenciamento de Imagens

### Adicionar Imagens de Produtos

As imagens devem ser adicionadas manualmente ao servidor na pasta:

```
assets/images/products/
```

#### Recomendações para Imagens:

- **Formato**: JPG, PNG ou WebP
- **Tamanho**: Máximo 500KB por imagem
- **Dimensões**: Mínimo 400x400px (quadrado é ideal)
- **Nome do arquivo**: Use nomes descritivos
  - ✅ Bom: `vestido-floral-vermelho.jpg`
  - ❌ Ruim: `img123.jpg`

#### Exemplo de Upload (cPanel):

1. Acesse o File Manager do cPanel
2. Navegue até `public_html/assets/images/products/`
3. Clique em "Upload"
4. Selecione a imagem
5. Ao cadastrar o produto, use o caminho: `assets/images/products/nome-do-arquivo.jpg`

---

## 🔍 Solução de Problemas

### Não Consigo Fazer Login

**Possíveis causas:**

1. **Credenciais incorretas**
   - Verifique se está usando: `admin` / `admin123`
   - Certifique-se de que o CapsLock não está ativado

2. **Token expirado**
   - Limpe o localStorage do navegador
   - Tente fazer login novamente

3. **Banco de dados não configurado**
   - Verifique se o script `database/setup.sh` foi executado
   - Confirme se a tabela `admin_users` existe

### Produtos Não Aparecem Após Cadastro

**Verificações:**

1. **Verifique a API**
   - Teste: `http://localhost:8080/api/products.php`
   - Deve retornar JSON com os produtos

2. **Limpe o cache do navegador**
   - Pressione `Ctrl + F5` (Windows) ou `Cmd + Shift + R` (Mac)

3. **Verifique o console do navegador**
   - Pressione `F12` para abrir DevTools
   - Vá na aba "Console" e procure por erros

### Imagem Não Aparece

**Causas comuns:**

1. **Caminho incorreto**
   - Certifique-se de que o caminho está correto
   - Use sempre `assets/images/products/nome-arquivo.jpg`

2. **Arquivo não existe**
   - Verifique se a imagem foi enviada para o servidor
   - Confirme o nome do arquivo (case-sensitive)

3. **Permissões incorretas**
   - Arquivos devem ter permissão `644`
   - Pastas devem ter permissão `755`

### Erro "Token inválido" ou "Não autorizado"

**Solução:**

1. Faça logout
2. Limpe o localStorage:
   ```javascript
   // No console do navegador (F12)
   localStorage.clear()
   ```
3. Faça login novamente

### JWT Secret não configurado

**Erro:** `your-secret-key-change-this`

**Solução:**

1. Edite o arquivo `.env`
2. Altere a linha:
   ```
   JWT_SECRET=sua_chave_secreta_aleatoria_aqui_123456789
   ```
3. Gere uma chave aleatória segura (mínimo 32 caracteres)

---

## 🔒 Segurança

### Boas Práticas

1. **Altere a senha padrão imediatamente**
2. **Use senhas fortes**
   - Mínimo 8 caracteres
   - Combine letras, números e símbolos
3. **Não compartilhe credenciais**
4. **Altere o JWT_SECRET em produção**
5. **Use HTTPS em produção**
6. **Faça backup do banco de dados regularmente**

### Criar Novo Usuário Admin (via MySQL)

```sql
-- Acesse o MySQL
mysql -u root -p

-- Use o banco de dados
USE ll_magazine_db;

-- Gere o hash da senha (use o PHP ou outro método)
-- Senha: 'minhasenha123' gera o hash abaixo (exemplo)

INSERT INTO admin_users (username, email, password_hash, full_name, is_active)
VALUES (
    'novo_admin',
    'admin2@llmagazine.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Novo Administrador',
    TRUE
);
```

**Para gerar o hash da senha em PHP:**

```php
<?php
echo password_hash('sua_senha_aqui', PASSWORD_DEFAULT);
?>
```

---

## 📊 Dicas e Truques

### Produtos em Destaque

Marque produtos importantes como "Destaque" para que apareçam primeiro na listagem do site.

### Organização de Categorias

Use as categorias de forma consistente:
- **Looks**: Conjuntos completos
- **Feminino/Masculino**: Peças individuais por gênero
- **Infantil**: Roupas infantis
- **Presentes**: Acessórios e itens de presente

### Formatação de Preços

- Use sempre vírgula: `99,90` (não ponto)
- Não use R$: Apenas `99,90`
- Para centavos: `19,99` (sempre dois dígitos)

### Descrições Eficazes

Escreva descrições atrativas e informativas:
- ✅ "Vestido longo em tecido leve, perfeito para o verão"
- ❌ "Vestido"

---

## 📞 Suporte

Se encontrar problemas não listados neste guia:

1. Verifique os logs de erro:
   - `logs/error.log`
   - Console do navegador (F12)

2. Entre em contato com o desenvolvedor

---

**Desenvolvido para LL Magazine** 🛍️
