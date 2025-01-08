# Use an official PHP image as the base image
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/symfony

RUN deluser www-data

RUN groupadd -r www-data && \
    useradd -r -g www-data www-data -p ""

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data


# Dodanie komendy aby po wpisaniu run wykonuwać wszystko jako user www-data
RUN echo '#!/bin/bash\n su www-data -c "$@"' > /usr/local/bin/run
RUN chmod +x /usr/local/bin/run

# Install system dependencies and OpenSSL for key generation
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zip \
    openssl \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY ./app /var/www/symfony/

RUN chown -R www-data:www-data /var/www/symfony
# Set permissions for Symfony folders
#RUN mkdir var && mkdir var/cache && mkdir var/log && mkdir config && \
#    chown -R www-data:www-data var/cache var/log config
WORKDIR /var/www/symfony

RUN run "composer require symfony/maker-bundle \
  symfony/security-bundle \
   lexik/jwt-authentication-bundle \
   moneyphp/money"

# Install Symfony dependencies
RUN run "composer install --prefer-dist --no-scripts --no-interaction"
RUN compser install
# Set permissions for Symfony folders
RUN chown -R www-data:www-data var/cache var/log config

# Create the directory for JWT keys and generate keys
#RUN mkdir -p /var/www/symfony/config/jwt && \
#    openssl genpkey -algorithm RSA -out /var/www/symfony/config/jwt/private.pem -pkeyopt rsa_keygen_bits:4096 && \
#    openssl rsa -pubout -in /var/www/symfony/config/jwt/private.pem -out /var/www/symfony/config/jwt/public.pem && \
#    chmod 600 /var/www/symfony/config/jwt/private.pem && chmod 644 /var/www/symfony/config/jwt/public.pem

# Set the entrypoint to the script
# ENTRYPOINT ["/var/www/symfony/entrypoint.sh"]

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
