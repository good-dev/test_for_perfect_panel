FROM php:8-fpm-buster

RUN apt-get update && apt-get install -y --no-install-recommends \
        curl \
        wget \
        git \
        unzip \
        libzip-dev \
        gnupg2
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

CMD ["php-fpm"]