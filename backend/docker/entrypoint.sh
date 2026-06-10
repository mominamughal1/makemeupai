#!/bin/sh

PORT="${PORT:-8080}"
export PORT

echo "boot: PORT=$PORT" >&2

mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
php artisan migrate --force
php artisan storage:link --force 2>/dev/null || php artisan storage:link 2>/dev/null || true
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /tmp/nginx.conf
nginx -t -c /tmp/nginx.conf >&2

php-fpm -D
exec nginx -c /tmp/nginx.conf -g 'daemon off;'
