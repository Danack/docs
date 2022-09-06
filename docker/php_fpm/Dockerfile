FROM debian:10-slim AS builder

USER root

RUN apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y git \
    mariadb-client wget curl \
    ca-certificates lsb-release apt-transport-https gnupg


RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee -a /etc/apt/sources.list.d/php.list \
    && curl https://packages.sury.org/php/apt.gpg | apt-key add - \
    && apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y php8.1 php8.1-common php8.1-cli php8.1-fpm \
    php8.1-mysql  php8.1-curl php8.1-xml php8.1-mbstring \
    php8.1-intl php8.1-redis php8.1-zip tidy graphviz

# php8.1-imagick
# php8.1-memcached

WORKDIR /var/www

# Set up configuration volumes
RUN mkdir -p /etc/config

# Used by Jenkins to package code in to container
# COPY web /var/www

# CMD ["/usr/sbin/php-fpm8.1", "--nodaemonize", "--fpm-config=/etc/config/fpm.conf", "-c", "/etc/config/php.ini"]

CMD sh /var/www/docker/php_fpm/run.sh
