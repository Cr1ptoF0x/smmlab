#!/bin/bash
set -e

# Set proper permissions for Laravel storage and cache
if [ -d "/var/www/html/core/storage" ]; then
    chown -R www-data:www-data /var/www/html/core/storage
    chmod -R 775 /var/www/html/core/storage
fi

if [ -d "/var/www/html/core/bootstrap/cache" ]; then
    chown -R www-data:www-data /var/www/html/core/bootstrap/cache
    chmod -R 775 /var/www/html/core/bootstrap/cache
fi

# Make sure assets and install directories are readable
chown -R www-data:www-data /var/www/html/assets 2>/dev/null || true
chown -R www-data:www-data /var/www/html/install 2>/dev/null || true

echo "============================================="
echo " SMMLab is ready!"
echo " App:         http://localhost:8000"
echo " Installer:   http://localhost:8000/install/"
echo " phpMyAdmin:  http://localhost:8080"
echo "============================================="
echo ""
echo " Database credentials for installer:"
echo "   Host:     db"
echo "   Database: smmlab"
echo "   User:     smmlab_user"
echo "   Password: smmlab_pass_2024"
echo "============================================="

# Execute the CMD
exec "$@"
