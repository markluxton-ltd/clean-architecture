# Base image
FROM php:7.3-apache

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Run apt update and install some dependancies needed for docker-php-ext
RUN apt-get update \
    && apt-get install -y apt-utils \
        mariadb-client \
        pngquant \
        unzip \
        zip \
        libpng-dev \
        libmcrypt-dev git \
        curl \
        libicu-dev \
        libxml2-dev \
        libssl-dev \
        libcurl4 \
        libcurl4-gnutls-dev \
        libsqlite3-dev \
        libsqlite3-0 \
        libzip-dev

# Install PHP extensions
RUN pecl install xdebug
RUN docker-php-ext-install mysqli bcmath gd intl xml pdo_mysql pdo_sqlite hash dom session opcache zip
RUN docker-php-ext-enable xdebug

# Update web root to public
# See: https://hub.docker.com/_/php#changing-documentroot-or-other-apache-configuration
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APACHE_LOG_ROOT /var/log/apache2Logs/

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer

RUN php /tmp/composer-setup.php
RUN rm /tmp/composer-setup.php
RUN mkdir -p /usr/local/bin && mv composer.phar /usr/local/bin/composer
RUN rm /var/log/apache2/error.log
RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
RUN a2enmod headers

# ini settings for xdebug
RUN echo "xdebug.remote_enable = 1" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back = 1" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN composer global require laravel/installer
RUN echo 'export PATH=$PATH:/root/.composer/vendor/bin' >> /root/.bashrc
RUN date > /build_date.txt

# Enable mod_rewrite
RUN a2enmod rewrite
