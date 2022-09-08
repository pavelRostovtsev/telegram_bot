FROM php:8.1-fpm-alpine

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG USER=www-data
ARG GROUP=www-data

WORKDIR /var/www

RUN set -xe \
 && apk --no-cache add shadow \
    openssh-client \
    bash \
    make \
 && usermod -u $USER_ID $USER && groupmod -g $GROUP_ID $GROUP \
 && apk del shadow


# Install php-extension-installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN set -xe \
    && install-php-extensions pdo_pgsql redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker-files/php-fpm/php.ini /usr/local/etc/php/php.ini

COPY docker-files/php-fpm/entrypoint.sh /

COPY --chown=$USER . .

RUN chmod +x /entrypoint.sh

RUN set -xe \
    && chown -R $USER:$USER .

USER $USER

ENTRYPOINT ["/entrypoint.sh"]

CMD ["php-fpm"]
