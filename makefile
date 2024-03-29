seeds:
	docker exec -it micro-videos-app bash -c  "php artisan db:seed"

migrate:
	docker exec -it micro-videos-app bash -c  "php artisan migrate"

run-all-tests:
	docker exec -it micro-videos-app bash -c  "vendor/bin/phpunit"

coverage:
	docker exec -it micro-videos-app bash -c  "vendor/bin/phpunit --coverage-html storage/app/report"

list-all-routes:
	docker exec -it micro-videos-app bash -c  "php artisan route:list"

start:
	docker-compose up -d

build:
	docker-compose up -d --build

down:
	docker-compose down

stop:
	docker-compose stop

rm:
	docker-compose rm

dump:
	docker exec -it micro-videos-app bash -c  "composer dump-autoload"

fix-all:
	docker exec -it micro-videos-app bash -c  "composer run-script php-cs-fixer"
