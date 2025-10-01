#!/bin/bash
# LL Magazine - Database Setup Script

echo "=== LL Magazine Database Setup ==="
echo ""

# Check if .env file exists
if [ ! -f .env ]; then
    echo "Error: .env file not found!"
    echo "Please copy .env.example to .env and configure it first."
    exit 1
fi

# Load .env variables
source .env

echo "Database Configuration:"
echo "  Host: $DB_HOST"
echo "  Database: $DB_NAME"
echo "  User: $DB_USER"
echo ""

# Prompt for MySQL root password
read -sp "Enter MySQL root password: " MYSQL_ROOT_PASS
echo ""

# Create database
echo ""
echo "Creating database '$DB_NAME'..."
mysql -h "$DB_HOST" -u root -p"$MYSQL_ROOT_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✓ Database created successfully"
else
    echo "✗ Failed to create database"
    exit 1
fi

# Import schema
echo ""
echo "Importing database schema..."
mysql -h "$DB_HOST" -u root -p"$MYSQL_ROOT_PASS" "$DB_NAME" < database/schema.sql 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✓ Schema imported successfully"
else
    echo "✗ Failed to import schema"
    exit 1
fi

# Import seed data
echo ""
echo "Importing seed data..."
mysql -h "$DB_HOST" -u root -p"$MYSQL_ROOT_PASS" "$DB_NAME" < database/seed.sql 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✓ Seed data imported successfully"
else
    echo "✗ Failed to import seed data"
    exit 1
fi

# Grant privileges if needed
if [ "$DB_USER" != "root" ]; then
    echo ""
    echo "Granting privileges to user '$DB_USER'..."
    mysql -h "$DB_HOST" -u root -p"$MYSQL_ROOT_PASS" -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';" 2>/dev/null
    mysql -h "$DB_HOST" -u root -p"$MYSQL_ROOT_PASS" -e "FLUSH PRIVILEGES;" 2>/dev/null

    if [ $? -eq 0 ]; then
        echo "✓ Privileges granted successfully"
    else
        echo "⚠ Warning: Failed to grant privileges (may already exist)"
    fi
fi

echo ""
echo "=== Database setup complete! ==="
echo ""
echo "You can now start the development server:"
echo "  php -S localhost:8080"
echo ""
