FROM php:8.3-fpm

EXPOSE 5173

RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        zip \
        unzip \
        vim \
        libzip-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libfontconfig1 \
        libxrender1 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip gd bcmath pdo_mysql mysqli exif \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN cd /usr/bin \
    && curl -sS https://getcomposer.org/installer | php \
    && ln -s /usr/bin/composer.phar /usr/bin/composer

ENV NODE_VERSION=22.15.0
ENV NVM_DIR=/root/.nvm
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash \
    && . "$NVM_DIR/nvm.sh" \
    && nvm install ${NODE_VERSION} \
    && nvm use v${NODE_VERSION} \
    && nvm alias default v${NODE_VERSION} \
    && node --version \
    && npm --version

WORKDIR /src

ADD . /src

RUN mkdir -p /src/storage \
    && chown -R www-data:www-data /src/storage

ENTRYPOINT ["bash", "-c", "composer install && npm install && exec php-fpm"]