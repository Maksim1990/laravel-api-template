up:
	USER_ID=$(id -u) GROUP_ID=$(id -g) docker-compose up -d
down:
	docker-compose down -v
exec:
	docker exec -it laravel-api bash
rebuild-app:
	docker-compose up -d --build laravel-api
exec-mysql:
	docker exec -it mysql bash
exec-redis:
	docker exec -it redis bash
