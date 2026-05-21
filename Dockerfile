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
## Runtime stage: copy built artifacts only
## ============================================================
FROM php:8.3-cli-alpine AS runtime

# Install extension PHP dependencies di Alpine Linux (Termasuk Oniguruma)
RUN apk add --no-cache \
    oniguruma-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath opcache

WORKDIR /var/www/html

# Copy seluruh aplikasi dan asset yang sudah di-build dari stage builder
COPY --from=builder /var/www/html /var/www/html

# HAPUS file cache bawaan secara paksa agar Laravel membuat yang baru di server
RUN rm -f bootstrap/cache/*.php

# Buat folder log secara manual dan beri izin akses penuh secara brutal
RUN mkdir -p storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache public

# Buka port 80 untuk lalu lintas web di Railway
EXPOSE 80

# Jalankan PHP Built-in Web Server langsung mengarah ke folder public Laravel
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
