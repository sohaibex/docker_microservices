#!/bin/bash

# Stop and remove all containers defined in docker-compose.yml
docker-compose down



docker system prune -f


docker builder prune --all


docker volume prune --all

echo "Cleanup complete."
