init: docker-down-clear docker-pull docker-build docker-up
up: docker-up
down: docker-down
restart: docker-down docker-up
test: composer-test

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

composer-install:
	docker-compose exec php-fpm composer install

composer-development-enable:
	docker-compose exec php-fpm composer development-enable

composer-development-disable:
	docker-compose exec sphp-fpm composer development-disable

composer-test:
	docker-compose exec php-fpm composer test

logstash-logs:
	docker-compose logs -f -t logstash-local

asyncapi-generate:
	docker-compose run --rm node ./utilities/generate.sh -o /var/www/app -s /var/www/asyncapi/simple.yml
