FROM php:8.1-apache

# Instale as extensões PHP necessárias
RUN apt-get update && \
    apt-get install -y libicu-dev libpq-dev libpng-dev libjpeg-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install gd intl pdo pdo_mysql mysqli

# Configure o Apache
RUN a2enmod rewrite
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Configure o PHP
COPY php.ini /usr/local/etc/php/

# Copie o projeto Laravel para o container
# COPY . /var/www/html/
WORKDIR /var/www/html

# Instale as dependências PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN composer install

RUN chmod 666 -R /var/www/html/

# Defina as permissões corretas
RUN chown -R www-data:www-data /var/www/html