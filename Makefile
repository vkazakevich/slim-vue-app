php_service=book_ms_php

build:
	@docker-compose up -d --build

up:
	@docker-compose up -d

stop:
	@docker-compose down

exec:
	@docker exec -it $(php_service) $$cmd

composer-install:
	@make exec cmd="composer install"

create-database:
	@make exec cmd="php bin/create_tables.php"

populate_database:
	@make exec cmd="php bin/populate_database_with_fake_records.php"
