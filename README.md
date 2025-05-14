
# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

## Our Api Doccumentaion

Please check the our official documentation here [Official Documentation](/)


Clone the repository

    git clone https://github.com/Rafieaydin/Humic_Clypsera_be.git

Switch to the repo folder

    cd Humic_Clypsera_be

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve


jika ada kenala login di token service nya

    php artisan Passport:client --personal



You can now access the server at http://localhost:8000


**TL;DR command list**

    git clone https://github.com/Rafieaydin/Humic_Clypsera_be.git
    cd Humic_Clypsera_be
    composer install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## credit
- [framework laravel](https://laravel.com/)



