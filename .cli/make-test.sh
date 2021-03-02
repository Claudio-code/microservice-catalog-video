echo "add test name and path"
read testName

docker exec -it micro-videos-app bash -c  "php artisan make:test ${testName}"
