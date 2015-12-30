## Thermometer app

## crons
* * * * * cd /var/www/thermometer && php artisan temperature:store >/dev/null 2>&2
6 0 * * 1 cd /var/www/thermometer && php artisan temperature:mailReport >/dev/null 2>&1

built with Laravel PHP Framework