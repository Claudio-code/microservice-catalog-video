runSeeds:
	docker exec -it micro-videos-app bash -c  "php artisan db:seed"

migrate:
	docker exec -it micro-videos-app bash -c  "php artisan migrate"

start:
	docker-compose up -d

start:
	docker-compose up -d --build

down:
	docker-compose down

stop:
	docker-compose stop

rm:
	docker-compose rm

dump:
	composer dump-autoload
