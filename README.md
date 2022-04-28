# CRUD - `Customer` - proof of concept

The app was created as a test task for Clever Together.

Because Laravel already has `User` model, we'll be using `Customer` for our purpose.

# Requirements
PHP 8.1

# Setup
1. Clone the repo locally
2. Edit `.env` with your DB credentials, `APP_KEY` and `APP_URL`
3. Run `php composer:migrate` to create DB schema
4. Run `php artisan db:seed --class=DatabaseSeeder` in order to create some test customers.
5. Run `php artisan serve` to start the app.

# Notes
Code, which might be of interest, is located under:
1. `app/Http/Actions`
2. `app/Http/Enums`
3. `app/Http/Requests`
4. `app/Http/DataTransferObjects`
5. `app/Http/Controllers`
6. `app/Http/Models`
7. `app/database/Migrations`
8. `app/database/seeders`
9. `app/database/factories`
10. `app/tests`
