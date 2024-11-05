# Specify the source and destination paths
RSA_PUB_PATH := $(HOME)/.ssh/id_rsa.pub
RSA_PUB_DESTINATION := ./id_rsa.pub
RSA_PATH := $(HOME)/.ssh/id_rsa
RSA_DESTINATION := ./id_rsa

init: docker-down-clear docker-pull docker-build up app-init
up: docker-up
down: docker-down
restart: down up

############################
# DOCKER
############################
docker-up:
	docker compose up -d
docker-down:
	docker compose down
# Will delete all volumes
docker-down-clear:
	docker compose down -v --remove-orphans
docker-pull:
	docker compose pull
docker-build:
	docker compose build --pull

app-init: composer-install db-create migrations-up
db-create:
	docker compose run --rm app_class_management php bin/console doctrine:database:create --if-not-exists
migrations-up:
	docker compose run --rm app_class_management php bin/console doctrine:migrations:migrate -n
phpunit:
	docker compose run --rm app_class_management php bin/phpunit
console:
	docker exec -it app_class_management bash

############################
# CHECK
############################
lint:
	docker compose run --rm app_class_management sudo composer lint
cs-check:
	docker compose run --rm app_class_management sudo composer php-cs-check
cs-fixer:
	docker compose run --rm app_class_management sudo composer php-cs-fixer
phpstan:
	docker compose run --rm app_class_management sudo composer phpstan

############################
# COMPOSER
############################
composer-update:
	docker compose run --rm app_class_management sudo composer update -W -o
composer-install:
	docker compose run --rm app_class_management sudo composer install -o
