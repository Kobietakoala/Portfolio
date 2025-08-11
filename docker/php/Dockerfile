FROM php:8.3-fpm

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
COPY --chown=www:www ./src/composer.json ./src/composer.lock* ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy package.json files for Node.js dependencies
COPY --chown=www:www ./src/package.json ./src/package-lock.json* ./

# Install Node.js dependencies
RUN npm ci --only=production

# Copy application code (excluding node_modules thanks to .dockerignore)
COPY --chown=www:www ./src .

# Set proper permissions and create directories
RUN mkdir -p storage/framework/{cache,sessions,testing,views} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www:www /var/www \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

# Run Laravel post-install scripts
RUN composer install --no-dev --optimize-autoloader

USER www

EXPOSE 9000
CMD ["php-fpm"]