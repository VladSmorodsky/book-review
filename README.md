# Book Review Project


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
3. Run docker compose up command:
    ```shell
    docker compose up --build -d
    ```
4. Run application:
    ```shell
    php artisan serve
    ```
