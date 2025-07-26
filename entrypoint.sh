#!/bin/bash

# Création/Vérification du fichier .env
if [ ! -f .env ]; then
    echo "Création du fichier .env..."
    echo "APP_ENV=production" > .env
    echo "DB_DRIVER=pgsql" >> .env
    echo "DB_HOST=dpg-d221q115pdvs738gbss0-a.oregon-postgres.render.com" >> .env
    echo "DB_PORT=5432" >> .env
    echo "DB_NAME=maxit" >> .env
    echo "DB_USER=maxit_user" >> .env
    echo "DB_PASSWORD=BUJxqyXDS8MYceL1yVqPMu17yO7yaTT0" >> .env
fi

# Démarrage d'Apache
apache2-foreground