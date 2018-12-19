# product-server

### 1.How do we build and run it? 
Plase Read Installation section on README.md

### 2.What tools did you use? 
- Laravel
- MySQL
- Docker for local environment.

### 3.Why did you use them? 
**Why Laravel and MySQL**
To handle retrieve products and also ensure atomic data updates at a time. It's one of the best choices to use MySQL as database.
Laravel has many useful features such as database migrations, Eloquent, testing. 

**Why Docker**
To prepare for a large scale requests environment, I adapted Docker to set up a local environment. I would set up EKS as next step.

### 4.Did you intentionally leave stuff out? In that case, what and why? 


## Dependency

- docker, docker-compose

## Installation

- Setting up docker containers
```sh
./up-docker-compose-local.sh
```

- Initializing mysql database.
```sh
docker exec -it product-service-php sh
php artisan migrate --seed
```

## ssh on mysql container

```sh
# Please change your environment if you want.
vi product-service/docker.product-service-db/.env

docker exec -it product-service-db sh
mysql -uproduct-service -p product-service
```

### ssh on php-fpm docker container
You can execute php artisan commands and check log files on php-fpm docker container.

```sh
docker exec -it product-service-php sh
```

## Testing
You need to reset database before executing tests.
```sh
docker exec -it product-service-php sh
./tests/run.sh
```