<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## SmartFastPay Payment API Laravel

### Overview

This is a Payment API built with Laravel for the SmartFastPay application for the PHP developer position. It includes features such as authentication with JWT, payment processing using the Strategy pattern, Swagger documentation, and testing with Pest. The project is set up to run with Docker using Laravel Sail and uses Laravel Octane with Swoole for improved performance.

### Table of Contents

[Requirements](#requirements)<br />
[Installation](#installation)<br />
[Configuration](#configuration)<br />
[Running the API](#running-the-api)<br />
[Testing](#testing)<br />
[Swagger Documentation](#swagger-documentation)<br />
[Importing Insomnia Collection](#importing-insomnia-collection)

Laravel is accessible, powerful, and provides tools required for large, robust applications.

### Requirements
- PHP >= 8.2
- Docker
- Docker Compose
- Composer
- Node.js
- NPM (or Yarn)

### Installation

1. Clone the repository:
```sh
git clone git@github.com:bholiveiradev/smartfastpay.git
cd smartfastpay
```

2. Install the dependencies:
```sh
composer install
npm install
```

3. Copy and past the `.env` file:
```sh
cp .env.example .env
```

### Configuration

Update the `.env` file with your database, auth guard, JWT, l5-swagger and Octane settings:

```sh
#DB_CONNECTION=sqlite
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

OCTANE_SERVER=swoole

JWT_SECRET=Xa6gkGZCwsBsgNslON9AbeMcS3xfwQ2z4j54Cl0RNWsvZxJVG1i3lR2qsooZdtsg

AUTH_GUARD=api

L5_SWAGGER_GENERATE_ALWAYS=true
```

## Running the API
Set up Docker and Laravel Sail:

```sh
./vendor/bin/sail up -d
```

Run migrations and seed the database:

```sh
./vendor/bin/sail artisan migrate --seed
```

This command will create the necessary database tables and seed the database with the following records:

- Payment methods: `pix`, `boleto`, and `bank_transfer`.
- Test user: `test@example.com` with password `password`.

## Testing

To run the tests using Pest:

```sh
./vendor/bin/sail pest
```

## Swagger Documentation

Runing the swagger documentation:

```sh
./vendor/bin/sail artisan l5-swagger:generate
```

The API documentation is generated with Swagger. To access the Swagger UI, visit:

```sh
http://localhost/api/doc
```

## Importing Insomnia Collection

1. Export the Swagger JSON:

```sh
./vendor/bin/sail artisan l5-swagger:generate
```

2. Download the Swagger JSON file:

The generated Swagger file will be located at `storage/api-docs/api-docs.json`.

3. Import into Insomnia from the Swagger JSON file:

- Open Insomnia.
- Go to Create > Import > Select `+ File`.
- Drag and drop or choose the `swagger.json` or `insomnia-collection.json` file and Scan.

You should now see all the endpoints and be able to interact with them using Insomnia.

