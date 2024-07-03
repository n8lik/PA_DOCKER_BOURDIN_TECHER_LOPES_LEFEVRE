FROM php:8.2-apache

COPY ./API /var/www/html

COPY ./API/.htaccess /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql