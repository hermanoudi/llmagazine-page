-- ====================================================================
-- SCRIPT DE MIGRAÇÃO: Categoria "presentes" para "acessorios"
-- LL Magazine - Database Migration
-- Data: 2025-10-04
-- ====================================================================
--
-- Este script atualiza a categoria "presentes" para "acessorios"
-- tanto na tabela de categorias quanto em todos os produtos existentes.
--
-- IMPORTANTE: Execute este script no banco de dados de PRODUÇÃO
-- ====================================================================

-- Início da transação (garante atomicidade)
START TRANSACTION;

-- 1. Atualizar a tabela de categorias
-- Remove a categoria antiga "presentes" e adiciona "acessorios"
UPDATE `categories`
SET
    `id` = 'acessorios',
    `name` = 'Acessórios',
    `icon` = 'fa fa-shopping-bag',
    `updated_at` = CURRENT_TIMESTAMP
WHERE `id` = 'presentes';

-- 2. Atualizar todos os produtos que estavam na categoria "presentes"
UPDATE `products`
SET
    `category` = 'acessorios',
    `updated_at` = CURRENT_TIMESTAMP
WHERE `category` = 'presentes';

-- 3. Verificar os resultados (opcional - para conferência)
-- Descomentar as linhas abaixo se quiser verificar antes de confirmar
-- SELECT * FROM `categories` WHERE `id` = 'acessorios';
-- SELECT `id`, `name`, `category` FROM `products` WHERE `category` = 'acessorios';

-- Confirmar as alterações
COMMIT;

-- ====================================================================
-- FIM DO SCRIPT DE MIGRAÇÃO
-- ====================================================================
--
-- RESULTADO ESPERADO:
-- - Categoria "presentes" renomeada para "acessorios"
-- - Ícone atualizado para "fa fa-shopping-bag"
-- - Todos os produtos migrados para a nova categoria
--
-- Em caso de erro, as alterações serão revertidas automaticamente (ROLLBACK)
-- ====================================================================
