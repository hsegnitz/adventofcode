FROM php:8.0-fpm

MAINTAINER Holger Segnitz <holger@segnitz.net>

# RUN apt-get update -y && apt-get install -y libjpeg-dev libmagickwand-dev pngcrush imagemagick libpq-dev webp
# RUN pecl install -o -f redis xdebug imagick-3.4.4 && rm -rf /tmp/pear &&  docker-php-ext-enable redis imagick
# RUN docker-php-ext-configure gd --with-jpeg
# RUN docker-php-ext-install exif pgsql pdo_pgsql gd

#RUN pecl install -o -f xdebug parallel && rm -rf /tmp/pear &&  docker-php-ext-enable parallel

# RUN mkdir -p /usr/src/php/ext/parallel && curl -fsSL https://pecl.php.net/get/parallel | tar xvz -C "/usr/src/php/ext/parallel" --strip 1 && docker-php-ext-install parallel \
#  && mkdir -p /usr/src/php/ext/xdebug   && curl -fsSL https://pecl.php.net/get/xdebug | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 && docker-php-ext-install xdebug