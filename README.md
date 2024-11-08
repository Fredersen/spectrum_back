composer install
php bin/console lexik:jwt:generate-keypair
symfony console d:d:c
symfony console d:m:m
symfony server:start
