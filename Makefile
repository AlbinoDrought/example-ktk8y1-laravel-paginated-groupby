.PHONY: all
all: .env vendor database/database.sqlite
	php artisan migrate:fresh --seed
	php artisan serve

.PHONY: clean
clean:
	rm -f database/database.sqlite
	rm -rf vendor
	rm .env

.env:
	cp .env.example .env

vendor: composer.json composer.lock
	composer install

database/database.sqlite:
	touch database/database.sqlite
