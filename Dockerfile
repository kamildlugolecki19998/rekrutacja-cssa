FROM php:8.3-fpm

WORKDIR /var/www/symfony

# RUN deluser www-data

# RUN groupadd -r www-data && \
#     useradd -r -g www-data www-data -p ""

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zip \
    openssl \
    && docker-php-ext-install intl pdo pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY ./app /var/www/symfony/

# RUN chown -R www-data:www-data /var/www/symfony
# Set permissions for Symfony folders
#RUN mkdir var && mkdir var/cache && mkdir var/log && mkdir config && \
#    chown -R www-data:www-data var/cache var/log config
WORKDIR /var/www/symfony

COPY ./app/composer.json ./app/composer.lock /var/www/symfony/

#RUN run "composer install --prefer-dist --no-scripts --no-interaction"

EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
