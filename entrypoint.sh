#!/bin/bash
set -e

# Vérifie si les dépendances PHP sont installées
if [ ! -d "vendor" ]; then
    echo "Installation des dépendances PHP..."
    composer install
fi

# Vérifie si les dépendances Node.js sont installées (si nécessaire)
if [ ! -d "node_modules" ]; then
    echo "Installation des dépendances Node.js..."
    npm install
fi

# Applique les migrations de la base de données en mode développement (optionnel)
if [ "$APP_ENV" = "dev" ]; then
    echo "Application des migrations..."
    php bin/console doctrine:migrations:migrate --no-interaction
fi

# Démarre le serveur Symfony
echo "Démarrage du serveur Symfony..."
exec php -S 0.0.0.0:8000 -t public