#!/bin/bash
set -e

# Load the DATABASE_URL secret from the Docker secrets file
export DATABASE_URL=$(cat /run/secrets/database_url)

# Check if PHP dependencies are installed
echo "Installing PHP dependencies..."
composer install --no-interaction

# # Run database migrations 
echo "Applying database migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

# Start the Symfony server
echo "Starting the Symfony server..."
php -S 0.0.0.0:8000 -t public
