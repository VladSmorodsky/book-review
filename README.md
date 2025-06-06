# Book Review Project
The project is about book ratings. It's possible to see ratings, check reviews for a book and also send a review for it.
There are several filters were implemented: filter by popular books, filter by highest rated books for one and six latest months. 
Also, you can find a necessary book using searching by title.

Tech stack that used for project:
- Laravel
- MySQL
- Redis

Implemented features:
- Searching by book title
- Filtering: by popular books (reviews count) and by highest rated books for one month, six months and all time
- Caching: implemented request caching for better performance
- Rate limit: added rate limit to send books reviews

## Project Setup

1. Copy `.env.example` file and create `.env` file:
    ```shell
    cp .env.example .env
    ```
2. Set values in `.env` file. Required items for setting up:
    - `DB_CONNECTION`: connection to a database. Use `mysql` by default
    - `DB_PORT`: database port. Should be matched with the docker compose database port
    - `DB_DATABASE`: database name
    - `DB_USERNAME`: database username
    - `DB_PASSWORD`: database password
    - `DB_ROOT_PASSWORD`: database password for root user
    - `REDIS_CLIENT`: Redis client driver (phpredis, predis)
3. Run docker compose up command:
    ```shell
    docker compose up --build -d
    ```
4. Run application:
    ```shell
    php artisan serve
    ```
