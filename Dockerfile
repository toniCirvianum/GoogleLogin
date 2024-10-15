FROM php:8.2-apache
RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug
#composer
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN composer require phpmailer/phpmailer
RUN composer require google/apiclient
#apache
RUN a2enmod rewrite