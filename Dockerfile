# Laravel uchun PHP Docker imijini tanlang
FROM php:8.1-fpm

# Laravel uchun zaruriy paketlarni o'rnatamiz
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev unzip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html

COPY .docker/php.ini /usr/local/etc/php/

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]
