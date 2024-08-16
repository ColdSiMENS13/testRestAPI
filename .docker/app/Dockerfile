FROM php:8.2.1-fpm-alpine3.17

ENV TZ=Europe/Minsk

RUN apk add --update --no-cache \
    curl \
    zsh \
    zip \
    shadow \
    autoconf \
    bash \
    yarn \
    imagemagick \
 && echo "date.timezone=$TZ" > "$PHP_INI_DIR/conf.d/date-time-zone.ini" \
 && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY php.ini "$PHP_INI_DIR/php.ini"

COPY --from=mlocati/php-extension-installer:1.5.37 /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions xdebug-^3.2 pdo_mysql intl imagick-^3.7 soap gd redis

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
ADD . .

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

RUN mkdir /var/.composer
RUN chown www-data:www-data /var/.composer

ADD .bashrc /home/www-data/.bashrc

USER www-data

