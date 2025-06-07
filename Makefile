run:
	./vendor/bin/sail up

down:
	./vendor/bin/sail down -v

build:
	./vendor/bin/sail build --no-cache

config_clear:
	./vendor/bin/sail artisan config:clear

cache_clear:
	./vendor/bin/sail artisan cache:clear

migrate:
	./vendor/bin/sail artisan migrate

migrate_refresh:
	./vendor/bin/sail artisan migrate:refresh --seed

tinker:
	./vendor/bin/sail artisan tinker

route_list:
	./vendor/bin/sail artisan route:list
