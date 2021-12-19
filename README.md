
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

php artisan l5-swagger:generate

http://localhost:8005/api/documentation
