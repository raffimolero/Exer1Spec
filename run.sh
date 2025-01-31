#!/bin/bash

docker-compose build
docker-compose up -d
docker-compose exec php bash /app/rebuild.sh
docker-compose exec php bash
docker-compose down -v