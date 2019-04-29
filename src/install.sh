#!/usr/bin/env bash
composer install

source ./.env

#php wp-cli.phar config create --dbname=${MYSQL_DATABASE} --dbuser=${MYSQL_USER} --dbpass=${MYSQL_PASSWORD} --allow-root --extra-php <<PHP
#define( 'WP_DEBUG', true );
#define( 'WP_DEBUG_LOG', true );
#PHP

php wp-cli.phar core install --url=$WP_HOME --title=Example --admin_user=$WP_ADMIN --admin_password=$WP_PWD --admin_email=$WP_EMAIL --allow-root

php wp-cli.phar plugin activate flash_toolkit
php wp-cli.phar plugin activate panel
php wp-cli.phar plugin activate demo_importer
