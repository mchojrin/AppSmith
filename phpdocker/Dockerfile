FROM phpdockerio/php:8.0-cli

RUN apt-get update && \
    apt-get install -y git zip php8.0-xdebug php8.0-mysql

RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

WORKDIR /application