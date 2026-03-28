FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json ./
COPY vite.config.js ./
COPY resources ./resources
COPY app ./app
COPY routes ./routes
COPY public ./public

RUN npm install && npm run build

FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git \
    sqlite3 \
    unzip \
    libicu-dev \
    libsqlite3-dev \
    libzip-dev \
    && docker-php-ext-install intl pdo_sqlite zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/entrypoint.sh /usr/local/bin/app-entrypoint

COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN chmod +x /usr/local/bin/app-entrypoint \
    && cp .env.example .env \
    && mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && touch database/database.sqlite \
    && composer install --no-interaction --prefer-dist --optimize-autoloader \
    && chown -R www-data:www-data database storage bootstrap/cache

ENTRYPOINT ["app-entrypoint"]
CMD ["apache2-foreground"]
