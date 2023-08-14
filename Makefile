go:
	php artisan serve
railway: migrate seed storage-link start
PORT ?= 6985
start:
	PHP_CLI_SERVER_WORKERS=5 php -S 0.0.0.0:$(PORT)  -t public
migrate:
	php artisan migrate --force
seed:
	php artisan db:seed --force
storage-link:
	php artisan storage:link
install:
	composer install
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app public routes tests