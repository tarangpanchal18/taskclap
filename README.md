# Urbanclap Clone Project
### Step To Install

Follow each and every step to go seamless installation of admin panel

- Git Clone the project in your directory
- Go to that directory `cd laravel-core-admin`
- Install dependency `composer install`
- Install JS dependency `npm install && npm run dev`
- Copy ENV file `cp .env.example .env`
- Change Database Details inside `.env` file
- Perform `php artisan migrate`
- Perform `php artisan db:seed`
- Perform `php artisan key:generate`
- Perform `php artisan storage:link`
- All Set ! Now run the server using `php artisan serve`

### Plugins

Laravel Core Admin is currently extended with the following plugins.
Instructions on how to use them in your own application are linked below.

| Plugin | README |
| ------ | ------ |
| Laravel AdminLTE | https://github.com/jeroennoten/Laravel-AdminLTE |
| Laravel Datatable | https://yajrabox.com/docs/laravel-datatables/10.0 |
