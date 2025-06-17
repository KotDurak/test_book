FROM php:8.4-fpm-alpine

ARG UID=1000
ARG GID=1000

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html
WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Установка зависимостей
RUN apk update && apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libxpm-dev \
    autoconf \
    build-base \
    zlib-dev \
    libzip-dev \
    bash \
    imagemagick \
    lz4-dev \
    zstd-dev \
    pkgconfig \
    make \
    gcc \
    g++ \
    re2c

# Установка расширений PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm \
    && docker-php-ext-install gd pdo pdo_mysql

# Настройка пользователя
RUN delgroup dialout || true \
    && addgroup -g ${GID} --system yii \
    && adduser -G yii --system -D -s /bin/sh -u ${UID} yii \
    && sed -i "s/user = www-data/user = yii/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = yii/g" /usr/local/etc/php-fpm.d/www.conf \
    && echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

USER yii
CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]