FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip cron \
    && apt install -y libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-install intl opcache \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN usermod -u 1000 www-data

ADD docker/fpm/config/php-fpm-override.ini /usr/local/etc/php-fpm.d/zzz-docker.conf
# Copy the bash script
COPY docker/bin/app-command.sh /usr/local/bin/app-command.sh

# Give execution rights to the script
RUN chmod +x /usr/local/bin/app-command.sh

WORKDIR /usr/src/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /usr/src/app

# Run the script
CMD ["/usr/local/bin/app-command.sh"]