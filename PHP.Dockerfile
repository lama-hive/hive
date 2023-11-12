FROM php:8.2-fpm

ARG UID=1000

RUN apt-get update && apt-get install git unzip libzip-dev -y

RUN docker-php-ext-install pdo pdo_mysql zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl -o installer https://getcomposer.org/installer && php installer && rm installer && mv composer.phar /usr/local/bin/composer

RUN mkdir /home/skill && useradd -u $UID -d /home/skill skill && chown skill:skill /home/skill