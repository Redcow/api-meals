FROM dunglas/frankenphp:alpine

ENV FRANKENPHP_CONFIG="worker ./public/index.php"

RUN install-php-extensions \
    pdo_mysql \
#    xdebug \
    intl \
    zip \
    opcache \
    redis \
    sockets

#RUN echo "xdebug.mode=develop" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apk add --no-cache bash \
    && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
    && apk add symfony-cli

RUN apk add git \
    && git config --global user.email "plet.francois@gmail.com" \
    && git config --global user.name "Francois Plet"

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer