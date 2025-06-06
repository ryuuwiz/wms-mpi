# Warehouse Management System (WMS)
Mata Kuliah Manajemen Proyek Informatika

## Installation
### Docker Setup
- Clone this repository
- Run `sail up` to start the containers
- Run `sail composer install` to install the dependencies
- Run `sail npm install && sail npm run build` to install the frontend dependencies
- Run `sail artisan key:generate` to generate the application key
- Run `sail artisan migrate` to migrate the database
- Env
    ```env
    APP_URL=http://localhost
    APP_LOCALE=id
    APP_FALLBACK_LOCALE=id
    APP_FAKER_LOCALE=id_ID
    ```
- Run `sail artisan make:filament-user` to create admin user
- Run `sail artisan shield:super-admin` to add role super admin to user
### Local Setup
- Clone this repository
- Run `composer install` to install the dependencies
- Run `npm install && npm run build` to install the frontend dependencies
- Run `php artisan key:generate` to generate the application key
- Run `php artisan migrate` to migrate the database
- Env
    ```env
    APP_URL=http://localhost
    APP_LOCALE=id
    APP_FALLBACK_LOCALE=id
    APP_FAKER_LOCALE=id_ID
    ```
- Run `php artisan make:filament-user` to create admin user
- Run `php artisan shield:super-admin` to add role super admin to user

## Tools
- Laravel 12
- Filament 3.3
- Filament Shield 3.3
- Docker
- MySQL
- Redis
- Octane + Sail
- Vite
- Tailwind CSS
- PHP 8.4
- FrankenPHP

## Reference
- [Laravel](https://laravel.com/docs/12.x)
- [Filament](https://filamentphp.com/docs/3.x)
- [Octane](https://laravel.com/docs/12.x/octane)
- [Sail](https://laravel.com/docs/12.x/sail)
- [Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield#1-install-package)
