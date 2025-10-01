# Painel Administrativo - LL Magazine

Sistema de gerenciamento de produtos com autenticação JWT.

## 🚀 Acesso Rápido

- **Login:** `/admin/login.html`
- **Dashboard:** `/admin/index.html`

## 🔐 Credenciais Padrão

```
Usuário: admin
Senha: admin123
```

**⚠️ ALTERE A SENHA APÓS O PRIMEIRO LOGIN!**

## 📋 Funcionalidades

- ✅ Autenticação segura com JWT
- ✅ Gerenciamento completo de produtos (CRUD)
- ✅ Upload e gerenciamento de imagens
- ✅ Categorização de produtos
- ✅ Controle de estoque
- ✅ Produtos em destaque
- ✅ Alteração de senha
- ✅ Interface responsiva

## 🛠️ Tecnologias

- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Backend:** PHP 7.4+ com PDO
- **Autenticação:** JWT (JSON Web Tokens)
- **Banco de Dados:** MySQL 5.7+
- **Segurança:** Password hashing (bcrypt)

## 📚 Documentação Completa

Consulte o [Guia do Administrador](../docs/admin_guide.md) para instruções detalhadas.

## 🔒 Segurança

- Senhas protegidas com bcrypt
- Tokens JWT com expiração de 24h
- Proteção contra SQL Injection (prepared statements)
- Sanitização de inputs
- HTTPS obrigatório em produção

## 🐛 Troubleshooting

### Não consigo fazer login
1. Verifique se o banco foi configurado: `./database/setup.sh`
2. Confirme que a tabela `admin_users` existe
3. Limpe o localStorage do navegador

### API retorna erro 401
- Token expirou (faça login novamente)
- JWT_SECRET não configurado no `.env`

### Produtos não aparecem
- Verifique se a API está respondendo: `/api/admin/products.php`
- Confirme que o token está sendo enviado no header

## 📝 Notas

- Este painel é exclusivo para administradores
- Todos os endpoints estão protegidos por autenticação
- O token expira após 24 horas de inatividade
- Faça backup do banco antes de modificações importantes

---

**Sistema desenvolvido para LL Magazine**
