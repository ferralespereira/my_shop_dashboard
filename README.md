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

## Production Deployment via GitHub Actions

This repository includes a production deployment workflow at:

- `.github/workflows/deploy-production.yml`

The workflow runs on pushes to `main` and deploys the code directly to EC2 over SSH.

The workflow executes these steps on the EC2 host:

1. `git fetch --all --tags`
2. `git checkout main`
3. `git reset --hard origin/main`
4. `composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction`
5. `php yii migrate/up --interactive=0`
6. Optional service restart command

### Required GitHub Repository Secrets

- `EC2_HOST` EC2 public DNS or IP
- `EC2_USER` SSH user on the EC2 host (example: `ec2-user` or `ubuntu`)
- `EC2_PORT` Optional SSH port. Default is `22`
- `EC2_SSH_PRIVATE_KEY` Private key allowed to access the EC2 host
- `EC2_KNOWN_HOSTS` Optional `known_hosts` line(s) for strict host key validation
- `DEPLOY_PATH` Absolute path of the checked-out project on EC2
- `PHP_BIN` Optional PHP binary path. Default is `php`
- `COMPOSER_BIN` Optional Composer binary path. Default is `composer`
- `RESTART_COMMAND` Optional command to restart PHP-FPM, Nginx, Apache, Supervisor, etc.

### EC2-specific Setup

Example values:

- `EC2_HOST=ec2-xx-xx-xx-xx.compute-1.amazonaws.com`
- `EC2_USER=ec2-user`
- `DEPLOY_PATH=/var/www/my_shop_dashboard`
- `RESTART_COMMAND=sudo systemctl restart php8.3-fpm`

`EC2_KNOWN_HOSTS` can be generated with:

```bash
ssh-keyscan <ec2-public-dns>
```

Production host prerequisites:

- The repository is already cloned on the EC2 host at `DEPLOY_PATH`
- The server user can run `git`, `composer`, and `php`
- The production `.env` file and web server configuration already exist on the EC2 host
- The SSH user has permission to update the project directory
- EC2 Security Group allows SSH from GitHub Actions runner IPs or your restricted ingress strategy

### Notes

- This workflow updates the code already checked out on EC2 instead of building Docker images.
- `git reset --hard origin/main` discards uncommitted changes on the server inside `DEPLOY_PATH`.

