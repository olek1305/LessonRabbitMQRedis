# Wybieramy oficjalny obraz PHP 8.3
FROM php:8.3-cli

# Instalacja zależności systemowych
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip

# Instalacja zależności PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instalacja kompozytora
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ustawienie katalogu roboczego
WORKDIR /var/www

# Kopiowanie plików aplikacji do obrazu
COPY . .

# Instalacja zależności aplikacji za pomocą Composera
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Dodanie grupy i użytkownika 'admin'
RUN groupadd -g 1000 admin && \
    useradd -u 1000 -ms /bin/bash -g admin admin

# Zmiana właściciela katalogu na użytkownika 'admin'
RUN chown -R admin:admin /var/www

# Ustawienie użytkownika, na którym będą wykonywane dalsze polecenia
USER admin

# Domyślne polecenie do uruchomienia serwera
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
