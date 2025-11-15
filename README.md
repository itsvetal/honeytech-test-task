# Laravel Blog: Test Task
## Introduction
This project is an implementation of a blog on Laravel 11 using Docker (Laravel Sail) for local development. The project meets the test task requirements: CRUD for posts and tags, filtering by tags, REST API for lists of tags/posts, Blade templates for the frontend, SCSS for styling, database migrations, pagination, form validation and filter posts by tag.
## Requirements
- PHP 8.2+
- Laravel 12
- Composer
- Node.js 18+ (for Vite/SCSS)
- Docker (for Sail)
- MySQL 8.0 (in container)
## Running in Docker (Laravel Sail)
Laravel Sail is the official Docker stack for Laravel, including PHP, MySQL, phpMyAdmin. Configuration in docker-compose.yml and .env is already set up (with database honeytech_test_task).

1. File .env:

```ruby
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:rYcDf1B8EuiW2f5PEW/yS9xqnisg2Mjy3KZOoPVET/A=
APP_DEBUG=true
APP_PORT=8000
APP_URL=http://localhost:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=honeytech_test_task
DB_USERNAME=sail
DB_PASSWORD=password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

```
2. File docker-compose.yml :

```ruby
services:
    laravel.test:
        build:
            context: './vendor/laravel/sail/runtimes/8.4'
            dockerfile: Dockerfile
            args:
                WWWGROUP: '${WWWGROUP}'
        image: 'sail-8.4/app'
        extra_hosts:
            - 'host.docker.internal:host-gateway'
        ports:
            - '${APP_PORT:-80}:80'
            - '${VITE_PORT:-5173}:${VITE_PORT:-5173}'
        environment:
            WWWUSER: '${WWWUSER}'
            LARAVEL_SAIL: 1
            XDEBUG_MODE: '${SAIL_XDEBUG_MODE:-off}'
            XDEBUG_CONFIG: '${SAIL_XDEBUG_CONFIG:-client_host=host.docker.internal}'
            IGNITION_LOCAL_SITES_PATH: '${PWD}'
        volumes:
            - '.:/var/www/html'
        networks:
            - sail
        depends_on:
            - mysql
    mysql:
        image: 'mysql/mysql-server:8.0'
        ports:
            - '${FORWARD_DB_PORT:-3306}:3306'
        environment:
            MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
            MYSQL_ROOT_HOST: '%'
            MYSQL_DATABASE: '${DB_DATABASE}'
            MYSQL_USER: '${DB_USERNAME}'
            MYSQL_PASSWORD: '${DB_PASSWORD}'
            MYSQL_ALLOW_EMPTY_PASSWORD: 1
            MYSQL_EXTRA_OPTIONS: '${MYSQL_EXTRA_OPTIONS}'
        volumes:
            - 'sail-mysql:/var/lib/mysql'
            - './vendor/laravel/sail/database/mysql/create-testing-database.sh:/docker-entrypoint-initdb.d/10-create-testing-database.sh'
        networks:
            - sail
        healthcheck:
            test:
                - CMD
                - mysqladmin
                - ping
                - '-p${DB_PASSWORD}'
            retries: 3
            timeout: 5s
    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        platform: linux/amd64
        container_name: "${APP_NAME}-phpmyadmin"
        links:
            - mysql
        environment:
            PMA_HOST: mysql
            PMA_PORT: 3306
            PMA_ARBITRARY: 1
            UPLOAD_LIMIT: 300M
        restart: always
        ports:
            - 8081:80
        networks:
            - sail
networks:
    sail:
        driver: bridge
volumes:
    sail-mysql:
        driver: local

```
## Steps to Run:
### 1. Clone the Repository:

```ruby
git clone git@github.com:itsvetal/honeytech-test-task.git
```
### 2. Install Dependencies:
```ruby
composer install
npm install
```
### 3. Create .env and copy the contents from example with .env file above to your .env
### 4. Start Docker

```ruby
./vendor/bin/sail up -d  # -d for background
```
This starts:
- laravel.test:8000 — main server (PHP + Laravel).
- mysql:3306 — Database.
- phpmyadmin:8081 — phpMyAdmin (login: sail, password: password).

Logs: ./vendor/bin/sail logs.

### 5. Copy the contents from example with docker-compose.yml above to your file docker-compose.yml
### 6. Instead of repeatedly typing vendor/bin/sail to execute Sail commands, you may wish to configure a shell alias that allows you to execute Sail's commands more easily:
```ruby
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
Once the shell alias has been configured, you may execute Sail commands by simply typing sail. The remainder of this documentation's examples will assume that you have configured this alias:

```ruby
sail up -d
```
### 7. Migrations and Seeding:

```ruby
sail artisan migrate  # Create tables: posts, tags, post_tag_relations
sail artisan db:seed  # Optional: demo data (if seeder exists)
```
### 8. Build Assets:
```ruby
npm run dev  # For development (watch mode)
# Or npm run build for production
```
### 9. Access:
- Blog: http://localhost:8000 (or http://laravel.test:8000).
- phpMyAdmin: http://localhost:8081.
- Stop: sail down.

## Tips:
- Port conflicts: Change APP_PORT=8000 in .env.
- Storage link: sail artisan storage:link (for thumbnails).
- Debug: Enable in .env: APP_DEBUG=true.

# Project Architecture
The project follows MVC principles (Model-View-Controller) with a modular structure (App\Modules for Post/Tag). Uses Eloquent ORM, Blade for rendering, Vite for assets.

## Key Components:
### Models (app/Modules/):
- Post: Fields: title, content, thumbnail. Many-to-Many relation with Tag via post_tag_relations. Accessor thumbnail_url for Storage URL.
- Tag: Field: name (unique). Many-to-Many relation with Post.

### Controllers(in the Modules):
- PostController (Web): CRUD for posts (index with pagination/filter, store with thumbnail upload, update/sync tags).
- PostApiController(Api): REST endpoint /api/v1/posts - JSON without views.
- TagController (Web): CRUD for tags (index, store with unique validation).
- TagApiController(Api): REST endpoint /api/v1/tags — JSON without views.

### Routes (in the Modules):
- api
- web

### Templates (resources/views/):
- layouts/app.blade.php: Base layout with navbar, Tailwind/SCSS.
- posts/index.blade.php: List with filter, pagination, thumbnails.
- posts/create|edit|show.blade.php: Forms with image preview, multi-select tags.
- tags/index|create.blade.php: Tag list/form.

### Styling (resources/scss/app.scss):
- SCSS with Vite.

### Database (database/migrations):
- create_posts_table: id, title, content, thumbnail, timestamps.
- create_tags_table: id, name (unique), timestamps.
- create_post_tag_relations_table: post_id, tag_id (cascade delete).

### Validation (): 
PostRequest.php
- Rules for title, content, tags , thumbnail.
- messages
- attributes

TagRequest.php
- Rules for name.
- messages
- attributes

### Factories/Seeders (database/factories/seeders): 
For tests/demo (Faker for title/content/tags).

### Artisan Commands (app/Console/Commands):
- GenerateDemoData: Generates posts with tags/thumbnails (static from storage/thumbnails).

# Features:
- CRUD: Add/edit/delete posts/tags with thumbnails (upload to public/storage).
- Filtering: By tag in post list (GET ?tag=).
- Pagination: 10 posts/page (built-in).
- API: GET /api/tags (JSON), /api/posts?tag= (filter).
- Demo: "Generate Demo" button (/posts/demo) — 15 posts with tags/thumbnails.
- Dark Theme: JS toggle.
- Image Preview: JS for thumbnail in form.

# License
MIT License. Author: Vitalii Kryskiv. Date: November 2025.



