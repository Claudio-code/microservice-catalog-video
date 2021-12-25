#!/bin/bash

#On error no such file entrypoint.sh, execute in terminal - dos2unix .docker\entrypoint.sh
chown -R www-data:www-data .
chmod -R 777 .cli
composer install
npm install
chmod -R 777 node_modules
php artisan key:generate
php artisan migrate
php artisan db:seed

php-fpm
