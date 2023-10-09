# Blog-laravel-vue
Simple blog application based on vue and laravel

To clone the project use:
git clone https://github.com/DEV-ANSH-1121/Blog-laravel-vue

Setup .env file and provide your local database credentials.
You can also copy .env.example and rename it to .env

Run the following commands after clone for setup:
composer install
npm install
php artisan migrate --seed

After successfully setup, run the following two commands to start the server in two different terminal (console) :
php artisan serve
npm run dev


Project Details:
This project contains basic CRUD application for blogs.
It contains registration, login, logout.
Home page contains Blog List.
For creating, updating or deleting of Blogs, Login is required.
Logged In user can also change status of Blog from Blog List page
