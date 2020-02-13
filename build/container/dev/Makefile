up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear project-clear docker-pull docker-build docker-up project-init
test: project-tests

docker-up:
	USER_ID=`id -u` GROUP_ID=`id -g` docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	USER_ID=`id -u` GROUP_ID=`id -g` docker-compose build

project-init: project-composer-install project-assets-install project-wait-db project-migrations project-fixtures project-ready

project-clear:
	docker run --rm -v ${PWD}/../../..:/app --workdir=/app alpine rm -f .ready

project-composer-install:
	docker-compose exec -T php-fpm composer install

project-assets-install:
	docker-compose run --rm node yarn install
	docker-compose run --rm node npm rebuild node-sass

project-wait-db:
	until docker-compose exec -T postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

project-migrations:
	docker-compose exec -T php-fpm php bin/console doctrine:migrations:migrate --no-interaction

project-fixtures:
	docker-compose exec -T php-fpm php bin/console doctrine:fixtures:load --no-interaction

project-ready:
	docker run --rm -v ${PWD}/../../..:/app --workdir=/app alpine touch .ready

project-assets-dev:
	docker-compose run --rm node npm run dev

project-tests:
	docker-compose exec -T php-fpm php bin/phpunit
