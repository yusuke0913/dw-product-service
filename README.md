# product-service
This product-service is developed in a environment which uses Laravel MySQL, Docker Kubernetes.

## Installation

To set up your local environment on Mac, you need to install docker and docker-compose

```
brew install docker docker-compose docker-machine
```

You can also set your kubernetes dev environment. Please check [here](k83/README.md)

## Local dev environment
You need to up the docker containers and execute database migrations.

```sh
# launch the docker containers
./up-docker-compose-local.sh

# database migration
docker exec -it product-service-php sh
php artisan migrate --seed
```

## API Documentation

| METHOD        | URL           | Description |
| ------------- |-------------| -----|
| GET      | [http://localhost:8080/api/v1/products/all](http://localhost:8080/api/v1/products/all) | A list of all products |
| GET      | [http://localhost:8080/api/v1/products/detail/${productId}](http://localhost:8080/api/v1/products/detail/C99900161)      | Detailed product information |
| GET      | [http://localhost:8080/api/v1/products/size/${size}](http://localhost:8080/api/v1/products/size/28)      | A list of IDs of all the products of the same size |
| GET      | [http://localhost:8080/api/v1/products/collections](http://localhost:8080/api/v1/products/collections) | A list of all collections |
| GET      | [http://localhost:8080/api/v1/products/collection/${collectionId}](http://localhost:8080/api/v1/products/collection/dapper)      | A list of IDs of all the products in the same collection |
| POST      | [http://localhost:8080/admin-api/v1/products/import](http://localhost:8080/admin-api/v1/products/import)      | Update products from a passed products json file with post body |

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