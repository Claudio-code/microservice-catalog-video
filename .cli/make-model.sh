echo "add your model name"
read modelName

docker exec -it micro-videos-app bash -c  "php artisan make:model ${modelName} --all"
