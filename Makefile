PROJECT := php-intermediate
SERVICE := php
COMPOSE := docker compose

.DEFAULT_GOAL := help

help: ## Show available targets
	@echo "$(PROJECT) targets:"
	@grep -E '^[a-zA-Z_-]+:.*?## ' Makefile | awk 'BEGIN {FS=":.*?## "}; {printf "  \033[36m%-12s\033[0m %s\n", $$1, $$2}'

url: ## Print service URL
	@echo "Open: http://localhost:8080/?p=home"

build: ## build the image
	$(COMPOSE) build

start: ## launch the server
	$(COMPOSE) up -d
	@$(MAKE) url

stop: #stop the server
	$(COMPOSE) down

restart: ## restart the server
	$(COMPOSE) restart $(SERVICE)

logs: ## show logs
	$(COMPOSE) logs -f $(SERVICE)

ps: ## list active containers
	$(COMPOSE) ps -a

clean: ## Down + remove local images/volumes of this project
	$(COMPOSE) down -v --rmi local --remove-orphans
	@echo "Project cleaned (volumes, uploads, local images)."

destroy: ## Remove EVERYTHING (careful)
	$(COMPOSE) down -v --rmi all --remove-orphans
	docker system prune -af
	@rm -rf src/uploads
	@echo "Everything removed, including volumes and cached images."

.PHONY: build start stop restart logs ps clean destroy
