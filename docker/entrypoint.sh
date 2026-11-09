#!/bin/sh
set -e

if [ "$1" = "php-fpm" ]; then
  if [ -n "$DB_HOST" ]; then
    for i in 1 2 3 4 5 6 7 8 9 10; do
      php artisan migrate --force --no-interaction && break
      sleep 3
    done
  fi
fi

exec "$@"
