#!/bin/bash

echo "docker-compose up with local environment ..."

docker-compose --project-name product-service \
    -f docker-compose.yaml \
    -f docker-compose-local.yaml \
    up
