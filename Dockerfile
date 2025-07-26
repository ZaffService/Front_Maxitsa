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

# Installation des dépendances
RUN composer install --no-dev --optimize-autoloader

# Copie du reste des fichiers du projet
COPY . .

# Les variables d'environnement seront injectées par Render
CMD ["apache2-foreground"]