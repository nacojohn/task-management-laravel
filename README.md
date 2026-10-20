#Task Management Project

## How to run the project

To ensure that the project runs on every machine irrespective of dependencies, it was built with Laravel Sail.

Download and extract the zipped file or pull from GitHub.

Ensure that MySQL port is not running locally or port 8080 is in use.

In the project directory, run the command `php artisan sail:install` to install all requirements\
Then start the project with the command `./vendor/bin/sail up`
Run the migration and seed `./vendor/bin/sail artisan migrate --seed`

