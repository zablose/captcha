#!/usr/bin/env bash

set -e

bin=/usr/local/bin

. "${bin}/exit-if-root"
. "${bin}/functions.sh"
. "${bin}/source-env-file"

dir_web=${ZDI_DIR_WEB}
dir_app=${ZDI_DIR_WEB_APP}
user=${ZDI_USER_NAME}

user_home=/home/${user}
user_bin=${user_home}/bin
composer=${user_bin}/composer
log=/var/log/zdi-post-setup-php-fpm.log

. "${user_bin}/functions.sh"

{
    show_info 'Php-fpm post setup.'

    bash "${user_bin}/r-web"

    cd "${dir_web}"
    ${composer} install

    pushd "${dir_app}"
    php artisan key:generate --ansi
    php artisan vendor:publish --provider="Zablose\Captcha\CaptchaServiceProvider" --tag=config
    php artisan vendor:publish --provider="Zablose\Captcha\CaptchaServiceProvider" --tag=assets

    wait_for_db

    php artisan migrate:fresh

    popd
    php -d zend_extension=xdebug.so -d xdebug.mode=coverage vendor/bin/phpunit

    show_success "Php-fpm post setup complete. Log file '${log}'."

} 2>&1 | sudo tee ${log}
