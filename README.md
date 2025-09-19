Persyaratan: PHP 8.1+, Composer, MySQL, Node

Cara instal:

git clone <repo>

composer install

cp .env.example .env lalu atur DB

php artisan key:generate

php artisan migrate --seed

npm install && npm run dev (jika ada assets)

php artisan serve

