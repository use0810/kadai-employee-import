#!/bin/sh
set -e

cd /var/www

if [ ! -f vendor/autoload.php ]; then
  echo "🔧 Running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# 本番ではphp artisan serveではなくこちらで起動
# exec php-fpm

# Laravelサーバーを起動（外部アクセスできるように）
exec php artisan serve --host=0.0.0.0 --port=8000