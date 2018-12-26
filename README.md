# product-service
This product-service is developed in the environment which uses Laravel, MySQL, Docker, Kubernetes.

## How do we build and run it?
Please check Installation and Local dev environment section.

## What tools did you use?
Laravel, MySQL, Docker, Kubernetes

## Why did you use them?

#### Why MySQL
I need to retrieve products by some keys (such as size, collection_id) and import data at a time.
In this case relational database is a good option because it has indexes, locking and transaction systems.
At first I'm thinking to use DynamoDB as datastore but in the point of retrieving products, I decided to use MySQL.
 
#### Why Laravel
Laravel provides many useful features and especially Eloquent is so useful for working with MySQL.

#### Why Docker and Kubernetes
To prepare for high requests, I set up kubernetes and docker environment because It makes easier to scale up the service on the cloud platform such as AWS, GCP.

## Did you intentionally leave stuff out?
I left collections table on MySQL out to reduce queries on import request.

## Installation

To set up your local environment on Mac, you need to install docker and docker-compose

```
brew install docker docker-compose docker-machine
```

You can also set up by kubernetes. Please check [here](k83/README.md)

## Local dev environment
You need to lanuch the docker containers and execute database migrations.

```sh
# launch the docker containers
./up-docker-compose-local.sh

# database migration
docker exec -it product-service-php sh
php artisan migrate --seed
```

## API Documentation

| Method | Url                                                                                                                         | Description                                                     |
| ------ | --------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------- |
| GET    | [http://localhost:8080/api/v1/products/all](http://localhost:8080/api/v1/products/all)                                      | A list of all products                                          |
| GET    | [http://localhost:8080/api/v1/products/detail/${productId}](http://localhost:8080/api/v1/products/detail/C99900161)         | Detailed product information                                    |
| GET    | [http://localhost:8080/api/v1/products/size/${size}](http://localhost:8080/api/v1/products/size/28)                         | A list of IDs of all the products of the same size              |
| GET    | [http://localhost:8080/api/v1/products/collections](http://localhost:8080/api/v1/products/collections)                      | A list of all collections                                       |
| GET    | [http://localhost:8080/api/v1/products/collection/${collectionId}](http://localhost:8080/api/v1/products/collection/dapper) | A list of IDs of all the products in the same collection        |
| POST   | [http://localhost:8080/admin-api/v1/products/import](http://localhost:8080/admin-api/v1/products/import)                    | Update products from a passed products json file with post body |

## ssh on mysql container

```sh
# Please change your environment if you want.
vi product-service/docker.product-service-db/.env

docker exec -it product-service-db sh
mysql -uproduct-service -p product-service
```

## ssh on php-fpm docker container
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