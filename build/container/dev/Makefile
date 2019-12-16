init: docker-down docker-pull docker-build docker-up project-init

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

project-init: project-composer-install project-wait-postgres-db

project-composer-install:
	docker-compose exec -T php-fpm composer install

project-wait-postgres-db:
	until docker-compose exec -T postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done
