COMPOSE_FILE=compose.dev.yaml

dev:
	docker-compose -f $(COMPOSE_FILE) up --build -d

up:
	docker-compose -f $(COMPOSE_FILE) up -d

down:
	docker-compose -f $(COMPOSE_FILE) down

composer:
	docker-compose -f $(COMPOSE_FILE) run --rm workspace composer $(filter-out $@,$(MAKECMDGOALS))

copy-env:
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
		echo ".env created."; \
	else \
		echo ".env already exists."; \
	fi

migrate:
	docker-compose -f $(COMPOSE_FILE) run --rm workspace php artisan migrate

key-generate:
	docker-compose -f $(COMPOSE_FILE) run --rm workspace php artisan key:generate

migrate-rollback:
	docker-compose -f $(COMPOSE_FILE) run --rm workspace php artisan migrate:rollback

seed:
	docker-compose -f $(COMPOSE_FILE) run --rm workspace php artisan db:seed

shell:
	docker-compose -f $(COMPOSE_FILE) exec workspace bash
