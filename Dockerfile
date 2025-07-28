FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libssl-dev \
    libsasl2-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html/

# Installation des dépendances PHP avec Composer
RUN cd /var/www/html && composer update

RUN chown -R www-data:www-data /var/www/html/