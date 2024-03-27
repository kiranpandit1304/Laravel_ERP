#!/bin/sh
#start cronjob
#cron && tail -f /var/log/cron.log 'daemon off;' &
php artisan optimize:clear &
php artisan storage:link
php artisan migrate --force &
php -S 0.0.0.0:8080 -t public
