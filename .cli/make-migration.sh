echo "add your migration name"
read migrationName

docker exec -it micro-videos-app bash -c  "php artisan make:migration ${migrationName}"
