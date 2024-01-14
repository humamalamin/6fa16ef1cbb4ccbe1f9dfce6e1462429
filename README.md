# API SEND EMAIL

## Tech Stack
- PHP 8.0 or higher : https://www.php.net/downloads.php
- Postgres (Database) : https://www.postgresql.org/
- Docker (Container) : https://www.docker.com/get-started/
- Docker Compose : https://docs.docker.com/compose/
- Composer : https://getcomposer.org/download/
- Redis : https://redis.io/

please, all tech stack has been installed in your local 

## Configuration
All configuration is in `.env` file. Please create new database or using exists database and running query scripts inside file database.sql.
Import file collection.json in your Postman.

### Step by step run Project

```Shell
git clone git@github.com:humamalamin/6fa16ef1cbb4ccbe1f9dfce6e1462429.git
cd project
composer install
config file .env

// runing consumer
php queue php

// running producer
php -S localhost:8000
```

if finish to step on top, please test API use POSTMAN

### Check Standart Code PSR 12

```bash
vendor/bin/phpcs --standard=PSR12 app/

or 

composer test
```

### Run with Docker

```Shell
docker-compose up --build
```

*Note: I have tried to implement dockerize in this app. But somehow I always fail when running it. So I suggest to use the manual way to run this application. Sincerely