# CRUD - `Customer` - proof of concept

The app was created as a test task for Clever Together.

Because Laravel already has `User` model, we'll be using `Customer` for our purpose.

# Setup
1. Clone the repo locally
2. Edit `.env` with your DB credentials, `APP_KEY` and `APP_URL`
3. Run `php composer:migrate` for migrations
4. Run `php artisan db:seed --class=CustomerSeeder` in order to create some test customers.
