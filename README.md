# E-Court: General Certificate Court (GCC)

This is a part of E-court. management system.

Steps to install:

Clone or donwload the repository.
Change .env.example to .env
Create Database name:ecourt_certificate
Import sql from folder name:database

Run docker exec -it app sh. Inside the shell, run following commands:

:/# composer install/compser update
:/# php artisan key:generate
:/# php artisan config:cache
Then exit from the container.

Then Start development server

$ php artisan serve
# general_certificate_court_v1
