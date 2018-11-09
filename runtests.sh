#!/bin/bash

source .env

clear
composer dump-autoload
rm -rf var/cache/test/
bin/console doctrine:database:drop --force --env=test --no-debug
bin/console doctrine:database:create --env=test --no-debug
mysql -h centos_mariadb -u $DB_USER -p$DB_PASSWORD < ./config/scripts/mariadb/01_event_streams_table.sql
mysql -h centos_mariadb -u $DB_USER -p$DB_PASSWORD < ./config/scripts/mariadb/02_projections_table.sql
bin/console event-store:event-stream:create --env=test
bin/console event-store:projection:run post_projection --env=test -d
./bin/phpunit --stop-on-failure