#!/bin/sh

echo "refreshing migration ...."
php artisan migrate:refresh --seed

echo "executing phpunit ...."
vendor/bin/phpunit
