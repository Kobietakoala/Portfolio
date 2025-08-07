#!/bin/sh

# Utworzenie folderów jeśli nie istnieją
mkdir -p /var/www/bootstrap/cache
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/storage/app/public

# Ustawienie uprawnień
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Autoload Composer jeśli istnieje vendor
if [ -f /var/www/composer.json ]; then
    composer dump-autoload --no-dev --optimize
fi

# Uruchomienie php-fpm
exec "$@"
