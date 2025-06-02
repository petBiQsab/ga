FROM serversideup/php:8.2-fpm-nginx-alpine

USER root

# Install the intl extension with root permissions
RUN install-php-extensions ldap gd

COPY . /var/www/html

# Build app
RUN apk update \
    && apk --no-cache add mc htop npm

# Copy our app files as www-data (33:33)
COPY --chown=www-data:www-data . /var/www/html

USER www-data
