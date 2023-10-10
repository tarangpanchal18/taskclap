# Urbanclap Clone Project
A complete ready to use admin panel built in laravel with PSR coding starnadards and all coding best practices.

## Features
- Pre Integrated AdminLte Tempalte
- All listing comes with Datatable With Server Side rendering
- With PSR & Laravel Standards
- All classes are expandable to your need
- Contains readymade following modules
    - Users Module
    - Category with parent category concept
    - Website Banner Module
    - My Profile Module

## Prerequisites
What things you need to install this project and how to setup the project on local
- PHP `[8.0 or above]`
- Composer `[2.0 or above]`
- MySql `[mysqlnd 7.4.33 or above]`
- Node/NPM

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
| Laravel Cashier(not used)| https://laravel.com/docs/10.x/billing
| Stripe Checkout| https://stripe.com/docs/payments/checkout|

### Contribution
I love to welcome your contributions if you know Laravel / Vue.js.

### License
The MIT License (MIT). Please see [License File](https://opensource.org/license/mit/) for more information.
