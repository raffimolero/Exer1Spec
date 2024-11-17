#!/bin/bash

docker-compose down -v
docker-compose build
docker-compose up -d
docker-compose exec php bash