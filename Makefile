test:
	vendor/bin/pest

lint:
	vendor/bin/phpstan analyse -l 9 src

pipeline:
	vendor/bin/pest
	vendor/bin/phpstan analyse -l 9 src