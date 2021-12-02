FROM php:8.1-fpm-alpine3.15

RUN apk add --no-cache shadow openssl bash mysql-client nodejs npm git librdkafka-dev

# install and remove building packages
ENV PHPIZE_DEPS autoconf file g++ gcc libc-dev make pkgconf re2c libxml2 libxml2-dev autoconf php8-dev php8-pear \
        yaml-dev pcre-dev zlib-dev libmemcached-dev cyrus-sasl-dev

RUN apk add --no-cache $PHPIZE_DEPS && docker-php-ext-install pdo pdo_mysql

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN touch /home/www-data/.bashrc | echo "PS1='\w\$ '" >> /home/www-data/.bashrc

ENV DOCKERIZE_VERSION v0.6.1

RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data

WORKDIR /var/www

RUN rm -rf /var/www/html && ln -s public html

RUN echo 'xdebug.mode=coverage' >> /usr/local/etc/php/php.ini

USER www-data

EXPOSE 9000
