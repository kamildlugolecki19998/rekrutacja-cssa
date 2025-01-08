#!/bin/bash

echo "Building Docker image..."
docker-compose build --no-cache

echo "Starting Docker container..."
docker-compose up -d

echo "Waiting for container to start..."
sleep 10

docker exec -it cs-php sh -c "composer install --prefer-dist --no-scripts --no-interaction"

echo "Running database migrations..."
docker exec -it cs-php sh -c "php bin/console doctrine:migrations:migrate --no-interaction"

echo "Generating JWT keys..."
docker exec -it cs-php sh -c "php bin/console lexik:jwt:generate-keypair"

echo "Setup complete!"

