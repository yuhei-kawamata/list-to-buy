FROM php:8.2-fpm

# 必要なパッケージとPHP拡張をインストール
RUN apt-get update && apt-get install -y \
    zip unzip git libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Composer のインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# 依存関係のインストール
RUN composer install --no-dev --optimize-autoloader

# ポート設定と起動
EXPOSE 8000
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000