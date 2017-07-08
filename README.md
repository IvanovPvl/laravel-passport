## About
Simple application for demonstrating integration of Laravel Passport with Vue.js.

## Run
```bash
cd docker/
docker-compose -f docker-compose.local.yml up -d
docker-compose -f docker-compose.local.yml exec --user=docker lp_workspace bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan passport:install
php artisan db:seed
npm i
```
