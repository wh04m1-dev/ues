1. **Install Laravel dependencies:**
    ```bash
    composer install
    ```
3. **Create a copy of the `.env` file:**
    ```bash
    cp .env.example .env
    ```
4. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```
5. **Run database migrations:**
    ```bash
    php artisan migrate
    ```

