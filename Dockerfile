FROM php:8.2-apache


COPY ./html /var/www/html

COPY ./html/.htaccess /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN apt update && apt install iputils-ping -y