
help: ## Display this current help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-25s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ General

.PHONY=install-dev copy-env install-symfony start

copy-env: ## Copy .env.dist to .env
	cp -n ./apps/back/.env.dist ./apps/back/.env

install-dev: ## Install project
	docker compose build php
	docker compose up -d
	docker compose exec php composer install
	docker compose exec php bin/console doctrine:database:drop --if-exists --force
	docker compose exec php bin/console doctrine:database:create --if-not-exists
	docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec php bin/console doctrine:fixtures:load --no-interaction

start: ## Start project
	docker compose up -d

install-symfony: ## Install symfony
    docker compose run base-php composer create-project symfony/skeleton:"6.2.*" back

phpstan:
	docker compose run --rm php vendor/bin/phpstan analyse
