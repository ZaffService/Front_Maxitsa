FROM php:8.1-apache

# Installation des dépendances système et extensions PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql

# Activation du module rewrite d'Apache
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configuration du DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie des fichiers composer avant l'installation
WORKDIR /var/www/html
COPY composer.json composer.lock ./

# Création du fichier .env
RUN echo "APP_ENV=production" > .env \
    && echo "DB_DRIVER=pgsql" >> .env \
    && echo "DB_HOST=dpg-d221q115pdvs738gbss0-a.oregon-postgres.render.com" >> .env \
    && echo "DB_PORT=5432" >> .env \
    && echo "DB_NAME=maxit" >> .env \
    && echo "DB_USER=maxit_user" >> .env \
    && echo "DB_PASSWORD=BUJxqyXDS8MYceL1yVqPMu17yO7yaTT0" >> .env

# Installation des dépendances
RUN composer install --no-dev --optimize-autoloader

# Copie du reste des fichiers du projet
COPY . .

# Permissions pour Apache
RUN chown -R www-data:www-data /var/www/html

# Copie et configuration du script d'entrée
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Utilisation du script d'entrée
CMD ["entrypoint.sh"]