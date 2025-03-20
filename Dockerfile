FROM php:8.4-fpm

# Cài đặt các extension cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Sao chép mã nguồn
COPY . .

# Cài đặt dependencies
RUN composer install --no-scripts --no-interaction

# Quyền truy cập
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Chạy server
CMD php artisan serve --host=0.0.0.0 --port=8000
