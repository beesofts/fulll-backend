install: tools/composer-require-checker/vendor tools/phpstan/vendor tools/php-cs-fixer/vendor vendor

vendor: composer.lock
	composer install --prefer-dist
	@touch vendor

reset-database:
	php bin/console doctrine:database:drop --force
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate --no-interaction

up: vendor
	docker compose up -d

down:
	docker compose down

# TESTS

tests: composer-require-checker phpstan phpunit behat

composer-require-checker:
	php tools/composer-require-checker/vendor/bin/composer-require-checker check composer.json

phpunit: vendor
	php -d memory_limit=256M vendor/bin/phpunit --stop-on-defect

behat: vendor
	php vendor/bin/behat

phpstan: vendor tools/phpstan/vendor
	php -d memory_limit=512M tools/phpstan/vendor/bin/phpstan analyse

tools/phpstan/vendor: tools/phpstan/composer.lock
	composer install --working-dir="tools/phpstan"
	@touch tools/phpstan/vendor

tools/composer-require-checker/vendor: tools/composer-require-checker/composer.lock
	composer install --working-dir="tools/composer-require-checker"
	@touch tools/composer-require-checker/vendor

# CODING STYLE

cs: php-cs-fixer

php-cs-fixer: tools/php-cs-fixer/vendor
	mkdir -p var/php-cs-fixer
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix -v --show-progress=dots --diff

php-cs-fixer-dry-run: tools/php-cs-fixer/vendor
	mkdir -p var/php-cs-fixer
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix -v --show-progress=dots --diff --dry-run

tools/php-cs-fixer/vendor: tools/php-cs-fixer/composer.lock
	composer install --working-dir="tools/php-cs-fixer"
	@touch tools/php-cs-fixer/vendor
