ARG FROM_IMAGE=php:8.4-fpm-alpine
FROM $FROM_IMAGE

LABEL maintainer="p3s <p3s.one@gmail.com>"

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    sync && \
    install-php-extensions gd intl bcmath pdo_pgsql && \
    rm -rf /var/cache/apk/* && \
    touch /var/log/xdebug.log && \
    chmod 666 /var/log/xdebug.log && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ENV ENV="/root/.ashrc"
RUN echo "alias ll='ls -al'" > "${ENV}"
RUN alias ll="ls -al"
EXPOSE 9003

VOLUME /app
WORKDIR /app