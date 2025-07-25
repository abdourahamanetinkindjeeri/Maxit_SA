FROM php:8.2-fpm

# Installer extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    unzip \
    zip \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le code source
COPY . /var/www/html

# NGINX config
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Supervisor config
COPY ./supervisord.conf /etc/supervisord.conf

# Définir le répertoire de travail
WORKDIR /var/www/html

# Donner les droits
RUN chown -R www-data:www-data /var/www/html

# Exposer le port
EXPOSE 80

# Lancer supervisord (lance php-fpm + nginx)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
