# backend/Dockerfile

FROM php:8.4-fpm-alpine

# 必要なパッケージをインストール
RUN apk add --no-cache \
    zip unzip curl libzip-dev libpng-dev oniguruma-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip

RUN apk add --no-cache bash curl
COPY wait-for-it.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ指定
WORKDIR /www

# 権限設定など（Laravel用）
COPY . /www
RUN chown -R www-data:www-data /www \
    && chmod -R 755 /www/storage /www/bootstrap/cache
