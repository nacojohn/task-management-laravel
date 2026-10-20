#Task Management Project

## OPTION 1

### Requirements
- Composer (with PHP installed locally)
- Docker Desktop (on Windows, use WSL2)

### How to run the project

To ensure that the project runs on every machine irrespective of dependencies, it was built with Laravel Sail.

Download and extract the zipped file or pull from GitHub.

Ensure that MySQL port is not running locally or port 8080 is in use.

Copy the content of  `.env.example` to create `.env`
In the project directory, run the command `php artisan sail:install` to install all requirements\
Then start the project with the command `./vendor/bin/sail up`
Run the migration and seed `./vendor/bin/sail artisan migrate --seed`

## OPTION 2

## Requirements
- PHP 8.3 or higher
- Composer
- MySQL 8
- Node.js and npm

Copy the content of  `.env.example` to create `.env`

### Create a MySQL database named task_management, then set your DB_USERNAME and DB_PASSWORD in .env

php artisan migrate --seed
npm install
npm run build
php artisan serve

Open http://localhost:8000