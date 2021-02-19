http://localhost:8081/

## Installation

```
docker-compose up -d
docker-compose exec php php /var/projects/test-php/artisan migrate
docker-compose exec php php /var/projects/test-php/artisan parse
```
