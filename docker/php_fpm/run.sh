#!/usr/bin/env bash

set -e
set -x

/usr/sbin/php-fpm8.1 \
  --nodaemonize \
  --fpm-config=/var/www/docker/php_fpm/config/fpm.conf \
  -c /var/www/docker/php_fpm/config/php.ini

exit $?