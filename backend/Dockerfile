FROM php:8.2-fpm

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    zip unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip \
    && docker-php-ext-install pdo_mysql zip gd

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# wait-for-it.sh をコピー
COPY wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# 作業ディレクトリ指定
WORKDIR /var/www

# 権限設定など（Laravel用）
COPY . /var/www
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap


COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]