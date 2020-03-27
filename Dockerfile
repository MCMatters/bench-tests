FROM php:7.3-fpm

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt update \
    && apt install -y --no-install-recommends \
            git \
            libssl-dev \
            libxml2-dev \
            libzip-dev \
            nodejs \
            unzip \
            yarn \
            zip \
            zlib1g-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && yarn config set cache-folder ~/.yarn \
    && docker-php-ext-install bcmath pcntl zip > /dev/null \
    && docker-php-ext-configure zip --with-libzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
