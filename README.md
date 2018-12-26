# product-service
This is a kind of product management tool. We provide simple APIs to import and retrieve product data by some keys such as collection id and size.

## Tools and Why
This product-service is developed in the environment which uses Laravel, MySQL, Docker, Kubernetes.

#### Why MySQL
The service needs to retrieve products by some keys (such as size, collection_id) and process only one data import request at a time.
In this case adapting relational database is a good option because it has indexes, locking and transaction features.
At first I was thinking to use DynamoDB as datastore but in the point of retrieving products, I decided to use MySQL.
 
#### Why Laravel
Laravel provides many useful features and especially Eloquent is so useful for working with MySQL.

#### Why Docker and Kubernetes
To prepare for withstanding sudden spikes, I set up kubernetes and docker environment because it makes easier to scale up the service on Cloud Platforms such as AWS, GCP in the future.

#### Left out stuff
I did not include collections table on MySQL to reduce update queries on import request.
And Nodejs and DynamoDB was considered but soon left unused, because relational database with MySQL seems to be more suitable in this tool.

## Installation

To set up your local environment on Mac, you need to install docker and docker-compose

```
brew install docker docker-compose docker-machine
```

You can also set up by kubernetes (optional). Please check [here](k83/README.md) 

## Local dev environment
You need to launch the docker containers and execute database migrations.

```sh
# launch the docker containers
./up-docker-compose-local.sh

# database migration
docker exec -it product-service-php sh
php artisan migrate --seed
```

## APIs Documentation

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