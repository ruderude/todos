FROM php:7.4-apache

COPY ./apache2.conf /etc/apache2/
COPY ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update
RUN apt-get install -y wget git curl

RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g
RUN npm install n -g
RUN n stable

RUN apt-get install -y libzip-dev libonig-dev zip unzip
RUN docker-php-ext-install bcmath gettext mbstring mysqli pdo pdo_mysql zip
RUN docker-php-ext-configure zip

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN a2enmod rewrite
