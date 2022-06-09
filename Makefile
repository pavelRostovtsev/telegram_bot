#прокидываем переменные окружения в контейнер
USER_ID := $(shell id -u)
GROUP_ID := $(shell id -g)
COMPOSER = composer

#запуск docker-compose
docker-compose-go:
	USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID) COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 docker-compose up --build

build-backend-dev:
	$(MAKE) composer-dev

composer-dev:
	export SYMFONY_ENV=dev && $(COMPOSER) install

code-style:
	vendor/bin/php-cs-fixer fix -vvv  --dry-run

test:
	$(GROUP_ID)
	$(USER_ID)