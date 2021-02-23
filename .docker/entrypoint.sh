#!/bin/bash

#On error no such file entrypoint.sh, execute in terminal - dos2unix .docker\entrypoint.sh
chown -R www-data:www-data .
chmod -R 777 .cli
composer install
npm install
php artisan key:generate
php artisan migrate

php-fpm
