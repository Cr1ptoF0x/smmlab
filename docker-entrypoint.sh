#!/bin/bash
set -e

if [ -d "/var/www/html/core/storage" ]; then
    chown -R www-data:www-data /var/www/html/core/storage /var/www/html/core/bootstrap/cache 2>/dev/null || true
    chmod -R 775 /var/www/html/core/storage /var/www/html/core/bootstrap/cache 2>/dev/null || true
fi

exec "$@"
