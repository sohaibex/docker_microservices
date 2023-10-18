#!/bin/bash

# Create and start a local registry
docker run -d -p 5000:5000 --name local_registry registry:2

# List of directories
apps=("app_v1" "app_v2" "app_v3")

# Build and start services in app_v1
echo "Building and starting services in app_v1..."
(cd "app_v1" && docker-compose up -d --build)

# Tag the built webservice image for the local registry
docker tag app_v1_webservice:latest localhost:5000/webservice:latest

# Push the tagged image to the local registry
docker push localhost:5000/webservice:latest

# Start services in app_v2 and app_v3
for app in "${apps[@]:1}"; do  # Start from app_v2
    echo "Building and starting services in $app..."
    (cd "$app" && docker-compose up -d --build)
done

echo "Deployment complete."
