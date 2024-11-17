# Use PHP 8.3 CLI as the base image
FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libsodium-dev \
    libpq-dev

# Install PHP extensions
RUN docker-php-ext-install sockets pdo pdo_mysql sodium

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create the working directory and set it
WORKDIR /app

# Copy the application files into the container's /app directory
COPY . .

# Install application dependencies using Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Add 'admin' group and user
RUN groupadd -g 1000 admin && \
    useradd -u 1000 -ms /bin/bash -g admin admin

# Change ownership of the application files
RUN chown -R admin:admin /app

# Switch to the 'admin' user for subsequent commands
USER admin
