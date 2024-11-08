### Iniialisation de la base de données
```
mkdir -p secrets/
echo "votre_mot_de_passe_root_complexe" > secrets/mysql_root_password.txt
echo "votre_mot_de_passe_app_complexe" > secrets/mysql_password.txt
chmod 600 secrets/*
```