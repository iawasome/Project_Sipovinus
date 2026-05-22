# syntax=docker/dockerfile:1.7

## ============================================================
## Builder stage: install PHP deps + Node deps, build assets
## ============================================================
FROM php:8.3-apache AS builder

# Install OS dependencies for PHP extensions & build tools
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Install required PHP extensions (mbstring needs libonig-dev)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring bcmath opcache

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js (needed for Vite build)
ENV NODE_VERSION=20
RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get update && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy dependency manifests first
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Install PHP dependencies (production)
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-scripts \
    --optimize-autoloader

# Install Node dependencies
RUN npm ci

# Copy the rest of the app
COPY . .

# Build Vite assets
RUN npm run build

# Ensure Laravel directories exist
RUN mkdir -p storage/app storage/framework storage/logs bootstrap/cache public/build


## ============================================================
## Runtime stage: PHP + Caddy (Super Stabil, Ringan & Aset Terbuka)
## ============================================================
FROM php:8.3-fpm-alpine AS runtime

# Install Caddy Server dan dependensi PHP di Alpine Linux
RUN apk add --no-cache caddy oniguruma-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath opcache

WORKDIR /var/www/html

# Copy seluruh aplikasi dari stage builder
COPY --from=builder /var/www/html /var/www/html

# Hapus file cache bawaan secara paksa agar Laravel membuat yang baru di server
RUN rm -f bootstrap/cache/*.php

# Beri izin akses folder storage & cache secara penuh
RUN mkdir -p storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache public

# Buat file konfigurasi Caddy dengan format EOF (Jauh Lebih Aman & Rapi)
RUN printf '{\n\tadmin off\n}\n\n:80 {\n\troot * /var/www/html/public\n\tfile_server\n\tphp_fastcgi 127.0.0.1:9000\n\tlog {\n\t\toutput stdout\n\t}\n}\n' > /etc/caddy/Caddyfile

# Buka port 80 untuk Railway
EXPOSE 80

# KEMBALIKAN BARIS CMD PALING BAWAH JADI SEPERTI INI (Hapus perintah migrate:fresh):
CMD ["sh", "-c", "php-fpm -D && php artisan db:seed --force && caddy run --config /etc/caddy/Caddyfile --adapter caddyfile"]
