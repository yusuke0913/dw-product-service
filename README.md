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

- Docker

## Installation

```sh
./up-docker-compose-local.sh
```

## ssh on docker container 

### ssh on php-fpm docker container
```sh
docker exec -it product-service-php sh
```
You can execute php artisan commands on php-fpm docker container.

## Testing
You need to reset database before executing tests.
```sh
docker exec -it product-service-php sh
./tests/run.sh
```