-- Migration: Add Cosméticos Category
-- This script adds the 'cosmeticos' category to an existing database
-- Run this if you already have the database set up and want to add the new category

-- Insert the cosmeticos category
INSERT INTO `categories` (`id`, `name`, `icon`, `display_order`)
VALUES ('cosmeticos', 'Cosméticos', 'fa-solid fa-spa', 6)
ON DUPLICATE KEY UPDATE
    `name` = 'Cosméticos',
    `icon` = 'fa-solid fa-spa',
    `display_order` = 6;
