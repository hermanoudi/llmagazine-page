# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

LL Magazine is a responsive virtual storefront (vitrine virtual) for a clothing store. It's **not an e-commerce** - products redirect to WhatsApp for purchases. Built for GoDaddy hosting with red/white branding.

## Development Commands

### Initial Setup

**1. Configure Environment:**
```bash
# Copy .env template and configure
cp .env.example .env
# Edit .env with your database credentials and WhatsApp number
```

**2. Create Database:**
```bash
# Login to MySQL
mysql -u root -p

# Create database and tables
mysql -u root -p < database/schema.sql

# Seed initial data (products and categories)
mysql -u root -p ll_magazine_db < database/seed.sql
```

### Local Development

**PHP Built-in Server (Recommended):**
```bash
php -S localhost:8080
# Access: http://localhost:8080
# API: http://localhost:8080/api/products.php
```

**Apache Setup:**
```bash
# Automated setup
sudo ./setup-apache.sh

# Manual setup
sudo cp ll-magazine.conf /etc/apache2/sites-available/
sudo a2ensite ll-magazine.conf
sudo systemctl reload apache2
echo '127.0.0.1 ll-magazine.local' | sudo tee -a /etc/hosts
# Access: http://ll-magazine.local
```

### Testing & Utilities

```bash
# Test local connectivity
./test-local.sh

# Generate placeholder images
python3 create_images.py

# Check Apache status/logs
systemctl status apache2
sudo tail -f /var/log/apache2/error.log
```

## Architecture

### Frontend-Backend Separation
- **Frontend**: Vanilla JavaScript (ES6+) with async/await for API calls
- **Backend**: PHP REST API serving JSON
- **Data Storage**: MySQL database with JSON fields for colors/sizes
- **Configuration**: Environment variables via `.env` file (not committed to git)

### API Structure (`api/products.php`)
- **GET /api/products.php** - All products
- **GET /api/products.php?category={category}** - Filtered products
- **GET /api/products.php?config=1** - Get WhatsApp config from .env
- **GET /api/products/{id}** - Single product (path-based routing)
- **GET /api/products/categories** - Get all categories
- **POST /api/products.php** - Contact/newsletter actions

**Rate Limiting**: 100 requests per 5 minutes per IP (file-based)
**Database**: Connects via PDO using credentials from `.env` file

### Frontend Architecture (`assets/js/script.js`)
- **Single-page application** pattern
- **Product filtering**: Client-side category filtering
- **Modal system**: Product details overlay
- **WhatsApp integration**: All "buy" actions redirect to WhatsApp (config loaded from API)
- **LocalStorage**: Favorites persistence
- **Lazy loading**: Images load on viewport intersection
- **Config loading**: Loads WhatsApp number from API on startup (from .env)

### Data Model (Products)
```php
[
    'id' => int,
    'name' => string,
    'category' => string, // 'looks', 'masculino', 'feminino', 'infantil', 'presentes'
    'price' => string, // Formatted: '179,90'
    'originalPrice' => string|null,
    'discount' => int|null,
    'image' => string, // Path: 'assets/images/products/{name}.jpg'
    'description' => string,
    'colors' => array, // Hex colors
    'sizes' => array, // ['PP', 'P', 'M', 'G', 'GG']
    'inStock' => bool
]
```

## Key Configuration Points

### Environment Variables (.env)
All sensitive configuration is stored in `.env` (not committed to git):
- **Database**: `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`
- **WhatsApp**: `WHATSAPP_NUMBER`, `WHATSAPP_MESSAGE`
- **Site**: `SITE_NAME`, `SITE_URL`, `SITE_EMAIL`
- **Environment**: `APP_ENV` (development/production)

**Important**: Always copy `.env.example` to `.env` and configure before running

### WhatsApp Integration
- **Config location**: `.env` file → `WHATSAPP_NUMBER`
- **Current number**: `5534991738581`
- **Message template**: `.env` → `WHATSAPP_MESSAGE`
- **Loading**: Frontend loads config from API endpoint on startup
- **Action flow**: Product click → Modal → Buy button → WhatsApp with product details

### Product Management
1. **Add Products**: Insert into `products` table in MySQL
2. **Update Products**: Use SQL UPDATE or create admin interface
3. **Images**: Place in `assets/images/products/` with exact filename from database

### Categories System
- Defined in `categories` table in MySQL database
- Categories: `all`, `looks`, `masculino`, `feminino`, `infantil`, `presentes`
- Each category has: `id`, `name`, `icon`, `display_order`
- Filter logic: Client-side in `filterProductsByCategory()`

### Database Schema
- **Tables**: `categories`, `products`
- **Location**: `database/schema.sql`
- **Seed Data**: `database/seed.sql` (initial products)
- **JSON Fields**: `colors` (array of hex colors), `sizes` (array of sizes)

## Design System

### Color Palette
- **Primary Red**: `#dc2626` (brand color)
- **Dark Red**: `#b91c1c` (hover states)
- **White**: `#ffffff`
- **Backgrounds**: `#fef2f2`, `#fecaca` (gradient in hero)

### Responsive Breakpoints
- Mobile: < 768px (hamburger menu appears)
- Tablet: 768px - 1024px
- Desktop: > 1024px

## GoDaddy Deployment Notes

1. Upload all files to `public_html/` (except `.env` - create it on server)
2. Create `.env` file on server with production credentials:
   - Copy `.env.example` to `.env`
   - Set `APP_ENV=production`
   - Configure GoDaddy MySQL database credentials
   - Set production URL in `SITE_URL`
3. Import database schema: `mysql -u username -p database_name < database/schema.sql`
4. Import seed data: `mysql -u username -p database_name < database/seed.sql`
5. Ensure PHP 7.4+ is enabled on GoDaddy
6. SSL/HTTPS must be active (redirect configured in `.htaccess.old`)
7. Verify `.env` is not accessible via web (should be blocked by server)

## Important Files

- **index.html** - Single-page app entry point
- **api/products.php** - Complete REST API with MySQL integration
- **assets/js/script.js** - All frontend logic (no build step required)
- **config.php** - Configuration loader (reads from .env)
- **.env** - Environment variables (NOT in git, copy from .env.example)
- **.env.example** - Template for environment configuration
- **database/schema.sql** - Database table definitions
- **database/seed.sql** - Initial product and category data
- **create_images.py** - Generates placeholder product images (requires Pillow)

## Development Practices

- **Language**: All user-facing content in Portuguese (pt-BR)
- **No build tools**: Direct file editing, no npm/webpack
- **Image optimization**: Use lazy loading, compress before upload
- **Security**:
  - Input sanitization functions in `config.php`
  - Never commit `.env` file
  - Use prepared statements for all database queries
  - Rate limiting on API endpoints
- **Error handling**: Custom 404/500 pages, API error responses with proper HTTP codes
- **Database**: All queries use PDO with prepared statements to prevent SQL injection
