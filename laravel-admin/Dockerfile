# Set up PHP 8.3 environment
FROM php:8.3-cli

# Added system dependencies (git, curl, zip, unzip)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libsodium-dev \
    libpq-dev

# Installed PHP extensions
RUN docker-php-ext-install sockets pdo pdo_mysql sodium

# Installed Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setting up the working directory
WORKDIR /var/www

# Copying application files to an image
COPY . .

# Installing application dependencies using Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Dodanie grupy i użytkownika 'admin'
RUN groupadd -g 1000 admin && \
    useradd -u 1000 -ms /bin/bash -g admin admin

# Added admin user with proper ownership
RUN chown -R admin:admin /var/www

# Set the user on which further commands will be executed
USER admin

