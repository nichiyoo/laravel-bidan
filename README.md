## Project Description

Bidan management system using laravel, tailwindcss, and alpinejs with sqlite database,
Make it easy to manage patients, appointments, and articles.

## Screenshots

![Screenhot](public/screenshot.png)

## Features

- Authentication
- Admin and Patient Authorization
- CRUD for Users
- CRUD for Patients
- CRUD for Appointments
- CRUD for Articles
- CRUD for Payment Methods
- CRUD for Diagnoses
- CRUD for Reviews
- Appointment Notification and Scheduling
- Payment Scheduling

## Requirements

- PHP 8.2
- Laravel 11.0
- Node LTS

## Installation

1. Clone the repository

```bash
git clone https://github.com/nichiyoo/laravel-bidan-app.git
```

2. Go to the project directory, and install the dependencies

```bash
cd athelete-app

composer install
npm install
```

3. Copy the .env.example file to .env and fill in the required details (app name, database, locale, and appointment related settings), example:

```bash
APP_NAME="Bidan Ernawati"

APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_FAKER_LOCALE=id_ID

DB_CONNECTION=sqlite

APPOINTMENT_TIMEOUT=30
APPOINTMENT_OPEN=6
APPOINTMENT_CLOSE=22
```

4. Create a storage folder `./storage/app/media`, then link it to the public folder.

First make sure you have the `storage/app/media` folder created, like so: 

```bash
root/
    app/
    bootstrap/
    ...
    storage/
        app/
            media/
            public/
    .env
    ...
```

Then run the following command:

```bash
php artisan storage:link
```

5. Generate the key and store it in the .env file

```bash
php artisan key:generate
```

6. Run the migration

```bash
php artisan migrate
```

The first migration with sqlite will prompt you to create a database file, you can choose the name and location of the database, or just press enter to use the default location.

7. Run the seeder

```bash
php artisan db:seed
```

8. Compile the assets

```bash
npm run build
```

9. Run the application

```bash
php artisan serve
```

10. Open your browser and navigate to http://localhost:8000, the default user for admin and patient is

```
# admin
email: admin@example.com
password: password

# patient
email: patient@example.com
password: password
``