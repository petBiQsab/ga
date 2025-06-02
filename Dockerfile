FROM serversideup/php:8.2-fpm-nginx-alpine

USER root

# Install the intl extension with root permissions
RUN install-php-extensions ldap gd

COPY . /var/www/html

# Build app
RUN apk update \
    && apk --no-cache add mc htop npm \
    && composer install --no-dev \
    && npm install vite laravel-vite-plugin \
    && npm run build \
    && cp .env.example .env

# Copy our app files as www-data (33:33)
RUN chown www-data:www-data -R /var/www/html

USER www-data
