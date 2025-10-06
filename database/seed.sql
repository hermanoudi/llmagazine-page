-- LL Magazine Database Seed Data
-- Initial data for categories and products

-- Insert categories
INSERT INTO `categories` (`id`, `name`, `icon`, `display_order`) VALUES
('all', 'Todos os Produtos', 'fa fa-camera', 0),
('looks', 'Looks', 'fas fa-tshirt', 1),
('masculino', 'Masculino', 'fas fa-tshirt', 2),
('feminino', 'Feminino', 'fas fa-female', 3),
('acessorios', 'Acessórios', 'fa fa-shopping-bag', 4),
('infantil', 'Infantil', 'fa fa-child', 5),
('cosmeticos', 'Cosméticos', 'fa-solid fa-spa', 6);

-- Insert products
INSERT INTO `products` (`name`, `category`, `price`, `original_price`, `discount`, `image`, `description`, `colors`, `sizes`, `in_stock`, `featured`) VALUES
(
    'Conjunto Black',
    'looks',
    '179,90',
    '299,90',
    30,
    'assets/images/products/conjunto-black.jpg',
    'Conjunto elegante em preto, perfeito para o dia a dia ou ocasiões especiais.',
    JSON_ARRAY('#000000', '#333333', '#666666'),
    JSON_ARRAY('PP', 'P', 'M', 'G', 'GG'),
    TRUE,
    TRUE
),
(
    'Conjunto Prime Listras',
    'looks',
    '179,90',
    NULL,
    NULL,
    'assets/images/products/conjunto-prime-listras.jpg',
    'Conjunto moderno com estampa listrada, ideal para um visual despojado e elegante.',
    JSON_ARRAY('#FFB6C1', '#FFFFE0', '#F0F0F0'),
    JSON_ARRAY('PP', 'P', 'M', 'G', 'GG'),
    TRUE,
    TRUE
),
(
    'Conjunto Corvette P',
    'looks',
    '179,90',
    NULL,
    NULL,
    'assets/images/products/conjunto-corvette.jpg',
    'Conjunto vibrante em rosa, perfeito para destacar sua personalidade.',
    JSON_ARRAY('#FF69B4', '#FFB6C1', '#FFC0CB'),
    JSON_ARRAY('PP', 'P', 'M', 'G', 'GG'),
    TRUE,
    FALSE
),
(
    'Vestido Floral Primavera',
    'feminino',
    '249,90',
    '349,90',
    25,
    'assets/images/products/vestido-floral.jpg',
    'Vestido romântico com estampa floral, ideal para a estação da primavera.',
    JSON_ARRAY('#FFB6C1', '#98FB98', '#F0E68C'),
    JSON_ARRAY('PP', 'P', 'M', 'G', 'GG'),
    TRUE,
    FALSE
),
(
    'Batom Avon Nude Terracota',
    'acessorios',
    '89,90',
    NULL,
    NULL,
    'assets/images/products/acessorios.jpg',
    'Blusa básica em algodão, essencial para qualquer guarda-roupa.',
    JSON_ARRAY('#FFFFFF', '#F5F5F5', '#E8E8E8'),
    JSON_ARRAY('PP', 'P', 'M', 'G', 'GG'),
    TRUE,
    FALSE
),
(
    'Conjunto Infantil',
    'infantil',
    '129,90',
    '179,90',
    20,
    'assets/images/products/infantil.jpg',
    'Conjunto Infantil.',
    JSON_ARRAY('#87CEEB', '#B0C4DE', '#D3D3D3'),
    JSON_ARRAY('PP', 'P', 'M', 'G', 'GG'),
    TRUE,
    FALSE
),
(
    'Camisa Social Vermelha',
    'masculino',
    '159,90',
    NULL,
    NULL,
    'assets/images/products/camisa-vermelha.jpg',
    'Camisa social em vermelho, elegante e versátil para o trabalho.',
    JSON_ARRAY('#DC2626', '#B91C1C', '#991B1B'),
    JSON_ARRAY('PP', 'P', 'M', 'G', 'GG'),
    TRUE,
    FALSE
),
(
    'Vestido Longo Elegante',
    'feminino',
    '399,90',
    '499,90',
    15,
    'assets/images/products/vestido-longo.jpg',
    'Vestido longo para ocasiões especiais, com corte impecável.',
    JSON_ARRAY('#000000', '#800080', '#4B0082'),
    JSON_ARRAY('PP', 'P', 'M', 'G', 'GG'),
    TRUE,
    FALSE
);
