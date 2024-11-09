#!/bin/bash

# Set root and app passwords
root_password="votre_mot_de_passe_root_complexe"
password="votre_mot_de_passe_app_complexe"

# Create the secrets directory if it doesn't already exist
mkdir -p secrets/

# Write the passwords to the secret files
echo "$root_password" > secrets/mysql_root_password.txt
echo "$password" > secrets/mysql_password.txt

# Output the DATABASE_URL with correct variable substitution
echo "mysql://spectrumuser:${password}@database:3306/spectrum?serverVersion=8.0&charset=utf8mb4" > secrets/database_url.txt

# Set secure permissions for the secrets files
chmod 600 secrets/*
