FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql \
    && a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html

CMD ["apache2-foreground"]