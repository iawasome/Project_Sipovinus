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

# Enable useful Apache modules
RUN a2enmod rewrite headers

# Install required PHP extensions (adjust if your project needs more)
# Common for Laravel apps
# mbstring needs libonig-dev (Oniguruma)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring bcmath opcache

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js (needed for Vite build)
# Railway build environments typically have no Node, so we install it here.
ENV NODE_VERSION=20
RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get update && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy dependency manifests first (better layer caching)
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Install PHP dependencies (production)
# NOTE: --no-scripts avoids running artisan scripts during build.
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-scripts \
    --optimize-autoloader

# Install Node dependencies and build frontend
RUN npm ci

# Copy the rest of the app
COPY . .

# Build Vite assets
RUN npm run build

# Ensure Laravel directories exist
RUN mkdir -p storage/app storage/framework storage/logs bootstrap/cache public/build

# Fix permissions for runtime write locations
# Apache user is www-data in the official image
RUN chown -R www-data:www-data storage bootstrap/cache

# Run Laravel optimization for production.
# This requires APP_KEY + other env vars.
# Railway typically injects them at build time only if you configured it so.
# If not available, these commands may fail; in that case the container will still run,
# but the caches won't be pre-generated.
# We make them best-effort so builds don't fail.
RUN set -eux; \
    php artisan config:clear || true; \
    php artisan route:clear || true; \
    php artisan view:clear || true; \
    php artisan view:cache || true; \
    php artisan config:cache || true; \
    php artisan route:cache || true; \
    php artisan optimize || true


## ============================================================
## Runtime stage: copy built artifacts only
## ============================================================
FROM php:8.3-apache AS runtime

RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite headers

# Install PHP extensions used by Laravel (keep in sync with builder)
# mbstring needs libonig-dev (Oniguruma)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring bcmath opcache

WORKDIR /var/www/html

# Copy application from builder
COPY --from=builder /var/www/html /var/www/html

# Ensure permissions for runtime write locations
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose HTTP
EXPOSE 80

# Production-friendly Apache settings
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf || true

# Default command
CMD ["apache2-foreground"]

