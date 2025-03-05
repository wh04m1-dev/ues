1. **Clone the project repository:**
   ```bash
   git clone https://github.com/CHANTHEA22/vcs_api.git
   ```
2. **Install Laravel dependencies:**
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
5. **Run database migrations and seed data (if needed):**
    ```bash
    php artisan migrate --seed
    ```

