#!/bin/sh

echo "refreshing migration ...."
php artisan migrate:refresh

echo "executing db:seed ..."
php artisan db:seed

echo "executing phpunit ...."
vendor/bin/phpunit
