#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi

mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
touch "${DB_DATABASE:-/var/www/html/database/database.sqlite}"
chown -R www-data:www-data database storage bootstrap/cache

php artisan key:generate --force >/dev/null 2>&1 || true

php artisan migrate --force --seed

exec "$@"
