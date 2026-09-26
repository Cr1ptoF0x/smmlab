#!/bin/bash
set -e

if [ -d "/var/www/html/core/storage" ]; then
    chown -R www-data:www-data /var/www/html/core/storage /var/www/html/core/bootstrap/cache 2>/dev/null || true
    chmod -R 775 /var/www/html/core/storage /var/www/html/core/bootstrap/cache 2>/dev/null || true

    # Local Docker mounts the source tree at runtime, so install vendor packages
    # into the mounted Laravel application when they are absent.
    if [ ! -f "/var/www/html/core/vendor/autoload.php" ] && [ -f "/var/www/html/core/composer.json" ]; then
        composer install --working-dir=/var/www/html/core --no-interaction --prefer-dist
    fi
fi

exec "$@"
