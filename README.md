# My Shop Dashboard

Yii3-based web application for managing shop data, including user auth and business category management.

## Tech Stack

- PHP `8.2+`
- Yii3 components (`yiisoft/router`, `yiisoft/view`, `yiisoft/di`, `yiisoft/yii-runner-http`, `yiisoft/yii-runner-console`)
- PostgreSQL (configured via `DB_DSN`, `DB_USERNAME`, `DB_PASSWORD`)
- Codeception for testing
- Docker + Docker Compose for containerized development and testing

## Features

- Home page (`/`)
- About Us page (`/about-us`)
- Authentication (`/login`, `/register`, `/logout`)
- Protected business category CRUD routes
- Console command support via `./yii`

## Project Structure

- `src/Domain/` Domain models and business logic
- `src/Web/` Web actions and templates
- `src/Migration/` Database migrations
- `config/` App configuration, DI, routes, params
- `public/` Web entrypoint (`public/index.php`)
- `tests/` Codeception suites (`Unit`, `Functional`, `Web`, `Console`)
- `docker/` Docker and environment compose files

## Local Setup (Without Docker)

1. Install dependencies:

```bash
composer install
```

2. Configure environment variables in `.env`:

```dotenv
APP_ENV=dev
APP_DEBUG=1
DB_DSN=pgsql:host=127.0.0.1;port=5432;dbname=database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

## HTTP Routes

Defined in `config/common/routes.php`:

- `GET /` -> `home`
- `GET /about-us` -> `about-us`
- `GET|POST /login` -> `auth/login`
- `GET|POST /register` -> `auth/register`
- `POST /logout` -> `auth/logout`
- `GET /business-categories` -> `business-category/list` (auth required)
- `GET|POST /business-categories/{id}` -> `business-category/edit` (auth required)
- `POST /business-categories/{id}/delete` -> `business-category/delete` (auth required)
