FROM serversideup/php:8.2-fpm-nginx-alpine

USER root

# Install the intl extension with root permissions
RUN install-php-extensions ldap gd

COPY . /var/www/html

# Build app
RUN apk update \
    && apk --no-cache add mc htop npm \
    && echo 'alias ll="ls -al"' >> /etc/profile

# Copy our app files as www-data (82:82)
COPY --chown=82:82 . /var/www/html

ENV ENV=/etc/profile

USER www-data
