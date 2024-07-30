FROM php:8.3.9-apache

RUN apt-get update && apt-get upgrade -y 
RUN docker-php-ext-install mysqli pdo pdo_mysql  && docker-php-ext-enable mysqli pdo_mysql

COPY . /var/www/html

EXPOSE 80