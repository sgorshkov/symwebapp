ARGS=$(filter-out $@, $(MAKECMDGOALS))

up: .docker-up
init: .composer-install .migrate
rebuild: .docker-down .docker-build up init
console: .docker-console
fixtures: .fixtures

.docker-up:
	docker-compose up -d

.docker-down:
	docker-compose down

.docker-build:
	docker-compose build

.docker-console:
	docker-compose exec php-fpm bash

.create-env:
	if [ ! -f './phpunit.xml' ]; then cp ./phpunit.xml.dist ./phpunit.xml; else exit 0; fi;

.composer-install:
	docker-compose exec php-fpm composer install

.migrate:
	docker-compose exec php-fpm bin/console doctrine:migrations:migrate --no-interaction

.fixtures:
	cd ./docker && docker-compose exec php-fpm ./bin/console doctrine:fixtures:load --no-interaction --no-debug
