FROM php:8.3-fpm-alpine

# Instalacja zależności systemowych
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    nodejs \
    npm

# Instalacja rozszerzeń PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalacja Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Utworzenie użytkownika
RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

# Kopiowanie skryptu entrypoint
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Ustawienie katalogu roboczego
WORKDIR /var/www

# Zmiana właściciela katalogu
RUN chown -R www:www /var/www

# Przełączenie na użytkownika www
USER www

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]