#!/bin/bash

# List of directories
apps=("app_v1" "app_v2" "app_v3")

for app in "${apps[@]}"; do
    echo "Stopping and removing services in $app..."
    (cd "$app" && docker-compose down)
done

# Prune all unused Docker objects
echo "Pruning all unused Docker objects..."
echo "y" | docker system prune --all

# Prune all unused volumes
echo "Pruning all unused volumes..."
echo "y" | docker volume prune --all

echo "Reset complete."
