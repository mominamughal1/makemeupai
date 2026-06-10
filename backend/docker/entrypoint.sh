#!/bin/sh
set -e

PORT="${PORT:-8080}"
export PORT

envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /tmp/nginx.conf

php-fpm -D
exec nginx -c /tmp/nginx.conf -g 'daemon off;'
