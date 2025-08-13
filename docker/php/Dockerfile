FROM php:8.3-fpm
ARG APP_ENV=development

# Install system dependencies including Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Create www user if not exists and modify PHP-FPM config
RUN groupadd -g 1000 www || true \
    && useradd -u 1000 -g www -s /bin/sh www || true \
    && sed -i 's/www-data/www/g' /usr/local/etc/php-fpm.d/www.conf

# Copy composer files first for better caching
COPY --chown=www:www ./src/composer.json ./
COPY --chown=www:www ./src/package.json ./

# Install dependencies based on environment (before copying all files)
ARG APP_ENV
RUN if [ "$APP_ENV" = "production" ] || [ "$APP_ENV" = "PROD" ]; then \
        echo "🏭 Installing PRODUCTION dependencies..." && \
        composer install --no-dev --optimize-autoloader --no-scripts; \
    else \
        echo "🔧 Installing DEVELOPMENT dependencies..." && \
        composer install --optimize-autoloader --no-scripts; \
    fi

# Copy application code (excluding node_modules thanks to .dockerignore)
COPY --chown=www:www ./src .
COPY --chown=www:www . /var/www

# Ensure critical directories exist and have proper permissions
RUN mkdir -p storage/framework/{cache,sessions,testing,views} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www:www /var/www \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

# Install Node.js dependencies
RUN if [ "$APP_ENV" = "production" ] || [ "$APP_ENV" = "PROD" ]; then \
        npm ci --only=production; \
    else \
        npm install; \
    fi

# Run composer scripts now that we have the full application
RUN composer dump-autoload --optimize

# Final permissions fix
RUN chown -R www:www /var/www && chmod -R 775 storage bootstrap/cache

USER www

EXPOSE 9000
CMD ["php-fpm"]