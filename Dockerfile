FROM php:8.2-fpm

# Installe nginx, supervisor et extensions nécessaires
RUN apt-get update && \
    apt-get install -y nginx supervisor libpq-dev unzip git && \
    docker-php-ext-install pdo pdo_pgsql

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copie les fichiers du projet
COPY . .

# Copie la config Nginx si elle existe, sinon crée une config par défaut
RUN if [ -f ".docker/nginx/default.conf" ]; then \
    cp .docker/nginx/default.conf /etc/nginx/conf.d/default.conf; \
    else echo "server { \
        listen 80; \
        root /var/www/html/public; \
        index index.php; \
        server_name _; \
        location / { \
            try_files \$uri \$uri/ /index.php?\$query_string; \
        } \
        location ~ \.php\$ { \
            fastcgi_pass 127.0.0.1:9000; \
            fastcgi_index index.php; \
            fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; \
            include fastcgi_params; \
        } \
        location ~* \.(jpg|jpeg|png|gif|ico|css|js)\$ { \
            expires max; \
            log_not_found off; \
        } \
    }" > /etc/nginx/conf.d/default.conf; \
    fi

# Copie la config supervisor si elle existe, sinon crée une config par défaut
RUN if [ -f "supervisord.conf" ]; then \
    cp supervisord.conf /etc/supervisor/conf.d/supervisord.conf; \
    else echo "[supervisord] \
nodaemon=true \
[program:nginx] \
command=nginx -g 'daemon off;' \
[program:php-fpm] \
command=php-fpm" > /etc/supervisor/conf.d/supervisord.conf; \
    fi

# Permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Crée le dossier uploads
RUN mkdir -p /var/www/html/public/uploads && chmod -R 777 /var/www/html/public/uploads

# Installe les dépendances PHP via Composer
RUN composer install --no-dev --optimize-autoloader || \
    (echo "Erreur lors de l'installation des dépendances Composer, poursuite du build...")

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
