init: docker-down-clear docker-pull docker-build docker-up project-init

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

project-init: project-composer-install project-assets-install project-wait-postgres-db project-migrations project-fixtures

project-composer-install:
	docker-compose exec -T php-fpm composer install

project-assets-install:
	docker-compose run --rm node yarn install

project-wait-postgres-db:
	until docker-compose exec -T postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

project-migrations:
	docker-compose exec -T php-fpm php bin/console doctrine:migrations:migrate --no-interaction

project-fixtures:
	docker-compose exec -T php-fpm php bin/console doctrine:fixtures:load --no-interaction

project-tests:
	docker-compose exec -T php-fpm php bin/phpunit
