#!/bin/bash

php bin/console cache:clear
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
