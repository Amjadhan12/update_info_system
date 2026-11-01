#!/usr/bin/env bash
set -o errexit

composer install --no-dev --optimize-autoloader --no-interaction
npm ci
npm run production

php artisan config:cache
php artisan route:cache
php artisan view:cache
