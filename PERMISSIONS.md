# Permissões Necessárias - LL Magazine

## 📁 Pastas que Precisam de Permissão de Escrita

### Desenvolvimento Local

```bash
# Pasta de upload de imagens de produtos
chmod -R 777 assets/images/products/

# Pasta de logs
chmod -R 777 logs/
```

### Produção (Hostinger)

No ambiente de produção, as permissões devem ser mais restritivas:

```bash
# Pasta de upload de imagens de produtos
chmod -R 755 assets/images/products/

# Pasta de logs
chmod -R 755 logs/

# Garantir que o servidor web possa escrever
chown -R www-data:www-data assets/images/products/
chown -R www-data:www-data logs/
```

## ⚠️ Problemas Comuns

### Erro: "Permission denied" ao fazer upload

**Sintoma:**
```
Warning: move_uploaded_file(...): Failed to open stream: Permission denied
```

**Solução:**
1. Verificar permissões: `ls -la assets/images/products/`
2. Ajustar permissões: `chmod -R 777 assets/images/products/` (dev)
3. Em produção: `chmod -R 755 assets/images/products/` + `chown www-data:www-data`

### Erro: Logs não são gravados

**Solução:**
```bash
mkdir -p logs/
chmod -R 777 logs/
```

## 🔒 Segurança

- **Desenvolvimento**: 777 (leitura/escrita para todos)
- **Produção**: 755 (apenas servidor web pode escrever)

## 📝 Verificação Rápida

```bash
# Verificar permissões atuais
ls -la assets/images/products/
ls -la logs/

# Verificar proprietário
stat assets/images/products/
stat logs/
```
