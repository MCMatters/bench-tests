FROM php:7.3-fpm

RUN apt update \
    && apt install -y --no-install-recommends \
            git \
            libssl-dev \
            libxml2-dev \
            libzip-dev \
            unzip \
            zip \
            zlib1g-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install bcmath pcntl zip > /dev/null \
    && docker-php-ext-configure zip --with-libzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
