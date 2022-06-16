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

# Fix problem with file owner

#  local owner ids
ARG USER_ID=1000
ARG GROUP_ID=1000

RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data

USER www-data

WORKDIR /var/www

CMD ["php-fpm"]