#!/bin/sh
set -e

cd /var/www

if [ ! -f vendor/autoload.php ]; then
  echo "🔧 Running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

exec php artisan serve --host=0.0.0.0 --port=8000
