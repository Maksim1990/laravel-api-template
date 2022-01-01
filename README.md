### Installation
```
USER_ID=$(id -u) GROUP_ID=$(id -g) docker-compose up -d
make exec
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan l5-swagger:generate
```

#### REST API Documentation
```
http://localhost:8005/api/documentation
```

### Testing
```
make exec
touch ./database/database.sqlite
./vendor/bin/phpunit
```
