FROM php:8.0.8-fpm-buster

ARG USER_ID
ARG GROUP_ID

RUN apt-get update && apt-get install -y wget \
  curl \
  git \
  grep \
  libmcrypt-dev \
  libxml2-dev \
  libtool \
  make \
  autoconf \
  g++ \
  supervisor \
  zip \
  nano \
  vim \
  redis \
  libzip-dev \
  libpng-dev libpng-dev \
  libcurl4-openssl-dev pkg-config libssl-dev

RUN pecl channel-update pecl.php.net

RUN pecl install redis mongodb
RUN docker-php-ext-enable redis mongodb
RUN docker-php-ext-configure zip
RUN apt-get install -y libjpeg-dev libfreetype6-dev
RUN docker-php-ext-install -j$(nproc) bcmath pcntl exif sockets gd

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN pecl install xdebug-3.0.1 && docker-php-ext-enable xdebug

ADD ./docker/php/php.ini /usr/local/etc/php/php.ini

### In case error cURL error 77: error setting certificate verify locations
RUN mkdir -p /etc/ssl/curl
RUN wget --no-check-certificate https://curl.haxx.se/ca/cacert.pem -O /etc/ssl/curl/cacert.pem
#######################

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data
# Set working directory PHP
WORKDIR /var/www

USER "${USER_ID}:${GROUP_ID}"
