# Use a modern PHP-FPM base image for stability on M3
FROM php:8.2-fpm-alpine

# Install the necessary MySQL driver (mysqli)
RUN apk add --no-cache \
    mysql-client \
    && docker-php-ext-install pdo_mysql mysqli

WORKDIR /var/www/html

EXPOSE 9000