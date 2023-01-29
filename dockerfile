FROM php:8.1-apache

# Labelling
LABEL author="Martin Sambulare <martin@rakhasa.com>"
LABEL maintainer="Martin Sambulare <martin@rakhasa.com>"
LABEL organization="Rakhasa Artha Wisesa"
SHELL ["/bin/bash", "-c"]

# Prequisite
RUN apt-get -y update && apt-get -y upgrade && apt-get dist-upgrade
RUN apt-get install -y git zip curl sudo unzip libicu-dev libbz2-dev libpng-dev libpq-dev libzip-dev libjpeg-dev zlib1g-dev libmcrypt-dev libreadline-dev libfreetype6-dev g++ curl
RUN pecl install redis

# npm stuff
# RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
# ENV NVM_DIR=/root/.nvm
# RUN . "$NVM_DIR/nvm.sh" && nvm install 16.18.0
# RUN . "$NVM_DIR/nvm.sh" && nvm use v16.18.0
# RUN . "$NVM_DIR/nvm.sh" && nvm alias default v16.18.0
# ENV PATH="/root/.nvm/versions/node/v16.18.0/bin/:${PATH}"
# RUN npm install -g npx

# Apache2 Configuration
ENV DOCUMENT_ROOT=/var/www/html
ENV APACHE_DOCUMENT_ROOT=$DOCUMENT_ROOT/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers

# PHP Configuration
ENV PHP_INI_TYPE=development
RUN mv "$PHP_INI_DIR/php.ini-$PHP_INI_TYPE" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install intl opcache pdo pdo_pgsql pgsql gd bz2 iconv bcmath calendar zip
RUN docker-php-ext-enable redis

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Container User's Cred Setup
ENV UID=1001
RUN useradd -G www-data,root -u $UID -d /home/arjuna arjuna
RUN mkdir -p /home/arjuna/.composer && chown -R arjuna:arjuna /home/arjuna

# Arguments
ARG APP_PORT=8000
ARG APP_HOST="127.0.0.1"

# Finalisation
COPY . $DOCUMENT_ROOT
WORKDIR $DOCUMENT_ROOT
RUN chown -R www-data:www-data $DOCUMENT_ROOT/..
RUN chmod 775 -R $DOCUMENT_ROOT/storage $DOCUMENT_ROOT/bootstrap/cache
USER www-data
# RUN composer install && php artisan key:generate
