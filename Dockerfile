# Utilizați o imagine de bază cu suport pentru PHP și Apache
FROM php:7.4-apache

# Directorul de lucru în interiorul containerului
WORKDIR /var/www/html

# Copiați fișierele aplicației în container
COPY . /var/www/html

# Instalați dependențele aplicației
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-interaction

# Setarea permisiunilor
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Exponăm portul 80 pentru serverul web
EXPOSE 80
