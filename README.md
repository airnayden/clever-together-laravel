# CRUD - `Customer` - proof of concept

## Requirements
PHP 8.1

## Setup
1. Clone the repo locally
2. Edit `.env` with your DB credentials, `APP_KEY` and `APP_URL`
3. Run `composer install` in order to get dependancies
4. Run `php composer:migrate` to create DB schema
5. Run `php artisan db:seed --class=DatabaseSeeder` in order to create some test customers.
6. Run `php artisan serve` to start the app.

## Testing
Run the following commands for tests:
1. Run `php artisan test`

## Demo
You can see a demo of the app here: https://clever-together-laravel.drpanchev.com/

## Notes

### Customer Meta Data
You can store additional data for a given customer. 

The meta-fields are defined in `app/Http/Enums/CustomerMetaDataCodeEnum.php`

## TODO
1. Write `negative` tests
2. Write `edge-case` tests
3. Add proper error handling and DB transaction commit / reversal.
4. Proper `Role` management. Now we're just seeding it to DB.
5. Advanced `CustomerMeta` management.

### Code, which might be of interest, is located under:
1. `app/Http/Actions`
2. `app/Http/Enums`
3. `app/Http/Requests`
4. `app/Http/DataTransferObjects`
5. `app/Http/DataFactories`
6. `app/Http/Controllers`
7. `app/Http/Models`
8. `database/Migrations`
9. `database/seeders`
10. `database/factories`
11. `resources/views`
12. `public/js`
13. `tests`
