#!/usr/bin/env bash

set -e

cd ${DAMP_WEB_DIR}
php /home/${DAMP_USER_NAME}/bin/composer update

cd ${DAMP_WEB_APP}
php artisan key:generate --ansi
php artisan migrate

cd ${DAMP_WEB_DIR}
php vendor/bin/phpunit
