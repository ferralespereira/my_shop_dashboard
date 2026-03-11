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
DB_DSN=pgsql:host=127.0.0.1;port=5432;dbname=<?= $urlGenerator->generate('business-category/list') ?>database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

3. Start the app:

```bash
composer serve
```

4. Open in browser:

- `http://127.0.0.1:8080`

## Docker Setup

1. Build and start development containers:

```bash
make build
make up
```

2. Open in browser:

- `http://localhost:${DEV_PORT}` (default from `docker/.env` is `80`)

3. Stop containers:

```bash
make down
```

Useful Docker Make targets:

- `make shell` Enter app container shell
- `make yii <args>` Run Yii console command in container
- `make composer <args>` Run Composer in container
- `make cs-fix` Run PHP CS Fixer
- `make rector <args>` Run Rector
- `make psalm <args>` Run Psalm

## Testing

Run all tests:

```bash
composer test
```

Run a specific suite or test file:

```bash
vendor/bin/codecept run Web
vendor/bin/codecept run Web tests/Web/AboutUsCest.php
```

Run tests with Docker test environment:

```bash
make test
make test Web
```

Coverage report (Docker test environment):

```bash
make test-coverage
```

## Quality Tools

Static analysis and code quality:

```bash
vendor/bin/psalm
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --diff
vendor/bin/rector process
vendor/bin/composer-dependency-analyser --config=composer-dependency-analyser.php
```

Or run via Make targets in Docker:

```bash
make psalm
make cs-fix
make rector process
make composer-dependency-analyser
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

## Notes

- Web tests use `composer serve` and expect the app at `http://127.0.0.1:8080`.
- Runtime logs are written under `runtime/logs/`.
