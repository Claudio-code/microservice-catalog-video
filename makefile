seeds:
	docker exec -it micro-videos-app bash -c  "php artisan db:seed"

migrate:
	docker exec -it micro-videos-app bash -c  "php artisan migrate"

migration:
	.cli/make-migration.sh

run-all-tests:
	docker exec -it micro-videos-app bash -c  "vendor/bin/phpunit"

require:
	.cli/composer-add-dependency.sh

model:
	.cli/make-model.sh

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
