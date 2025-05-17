#!/bin/sh
set -e

cd /var/www

if [ ! -f vendor/autoload.php ]; then
  echo "🔧 Running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# maatwebsite/excel を PhpSpreadsheet 対応の最新版で導入（v3系）
if ! grep -q "maatwebsite/excel" composer.lock 2>/dev/null; then
  echo "📦 Installing Laravel Excel (maatwebsite/excel)..."
  composer require maatwebsite/excel:^3.1
fi

# 念のため PhpSpreadsheet も明示的に入れる（maatwebsiteが依存してるが単体利用も見越して）
if ! grep -q "phpoffice/phpspreadsheet" composer.lock 2>/dev/null; then
  echo "📦 Installing PhpSpreadsheet..."
  composer require phpoffice/phpspreadsheet
fi

# 本番ではphp artisan serveではなくこちらで起動
# exec php-fpm



# Laravelサーバーを起動（外部アクセスできるように）
exec php artisan serve --host=0.0.0.0 --port=8000