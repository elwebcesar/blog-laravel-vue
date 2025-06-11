FROM php:8.2-fpm

# Install required dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    iputils-ping \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Verify installation of mysql-client
RUN which mysql

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Verify PHP extensions
RUN php -m | grep -q pdo_mysql && php -m | grep -q mbstring && php -m | grep -q exif && php -m | grep -q pcntl && php -m | grep -q bcmath && php -m | grep -q gd && php -m | grep -q zip
