############################################
# Base Image
############################################
ARG PHP_IMAGE=serversideup/php:8.2-fpm-nginx-alpine
FROM $PHP_IMAGE AS base

############################################
# Development Image
############################################
FROM base AS development

# Switch to root so we can do root things
USER root

# Save the build arguments as a variable
ARG USER_ID
ARG GROUP_ID

# Add some tools and aliases
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone && \
    apk update && \
    apk --no-cache add mc htop npm && \
    echo 'alias ll="ls -al"' >> /etc/profile && \
    echo 'alias art="php artisan"' >> /etc/profile

# Install missing extension with root permissions
#RUN install-php-extensions ldap gd

# Use the build arguments to change the UID
# and GID of www-data while also changing
# the file permissions for NGINX
RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID && \
    \
    # Update the file permissions for our NGINX service to match the new UID/GID
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID --service nginx
RUN chown www-data:www-data -R /composer

ENV PATH=/composer/vendor/bin:$PATH
RUN echo 'export "PATH=$PATH:/composer/vendor/bin"' >> /etc/profile

ENV ENV=/etc/profile

WORKDIR /app
# Drop back to our unprivileged user
USER www-data
