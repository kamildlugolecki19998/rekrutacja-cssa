#!/bin/bash

# Budowanie obrazu bez użycia cache
echo "Building Docker image..."
docker-compose build --no-cache

# Uruchomienie kontenera w tle
echo "Starting Docker container..."
docker-compose up -d

# Czekanie na uruchomienie kontenera
echo "Waiting for container to start..."
sleep 10  # Dajemy trochę czasu na uruchomienie kontenera

# Wykonanie komendy composer install w kontenerze
echo "Running composer install inside the container..."
# docker exec -it cs-php -c "composer install"

#docker exec -it cs-php sh -c "composer install --prefer-dist --no-scripts --no-interaction"
docker exec -it cs-php sh -c "composer install --prefer-dist --no-scripts --no-interaction"


# Dodatkowe kroki, jeśli są wymagane (np. migracja bazy danych)
 echo "Running database migrations..."
 docker exec -it cs-php sh -c "php bin/console doctrine:migrations:migrate --no-interaction"

# Informacja o zakończeniu
echo "Setup complete!"

