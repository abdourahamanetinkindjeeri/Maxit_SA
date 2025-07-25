# Dockerfile
FROM php:8.2-fpm

# Installer extensions nécessaires (ex: PostgreSQL, pdo, etc.)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_pgsql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le projet
COPY . /var/www/html

# Définir le dossier racine
WORKDIR /var/www/html

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html
