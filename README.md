# Building Goal managment, Habit managment platform with Laravel, Vue.js, Inertia.js

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

What things you need to install the software.

- Git.
- PHP.
- Nodejs.
- Composer.
- A webserver like Nginx or Apache.

### Install

Clone the git repository on your computer

`$ git clone https://github.com/ikramkhizar/journal.git`

You can also download the entire repository as a zip file and unpack in on your computer if you do not have git

After cloning the application, you need to install it's dependencies.

```
$ cd aviary
$ composer install
$ npm install
$ npm run dev
```

### Setup

- When you are done with installation, copy the `.env.example` file to `.env`

  `$ cp .env.example .env`

- Generate the application key

  `$ php artisan key:generate`

- Add your database credentials to the necessary `env` fields

- Migrate & Seed Database

  `$ php artisan migrate --seed`

### Run the application

`$ php artisan serve`

## Built With

- [Laravel](https://laravel.com) - The PHP framework for building the API endpoints needed for the application
- [Vue.js](https://vuejs.org/) - An approachable, performant and versatile framework for building web user interfaces.
- [Inertia](https://inertiajs.com/) - Build single-page apps, without building an API

## License

Please use and re-use however you want.
