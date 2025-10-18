#!/bin/sh
set -e

until nc -z -v -w30 db 3306
do
  echo "Waiting for database connection..."
  sleep 2
done

echo "Database is up - continuing..."

# Migrationen ausführen
php artisan migrate --force

# PHP-FPM starten
php-fpm
