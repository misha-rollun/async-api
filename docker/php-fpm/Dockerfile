FROM php:7.4-fpm

USER root

# Install ping and ip command for entrypoint.sh
RUN apt update \
    && apt install -y iputils-ping \
    iproute2 \
    git \
    unzip

# Install xdebug
RUN pecl install xdebug-3.0.2 && docker-php-ext-enable xdebug

COPY ./php-fpm.conf  /usr/local/etc/php-fpm.conf
COPY ./conf.d  /usr/local/etc/php/conf.d

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

# Extensions
RUN docker-php-ext-install sockets

# Set entrypoint
COPY ./entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

WORKDIR /var/www/app

CMD ["php-fpm", "-R"]
