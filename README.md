### Initialisation of the databases

*WARNING : Avoid using @ symbols in database passwords.*

1) Run the code bellow
```
cd spectrum_back
# Set database root and spectrumuser passwords
root_password="your_strong_root_database_password"
password="your_strong_spectrumuser_password"

# Create the secrets directory if it doesn't already exist
mkdir -p secrets/

# Write the passwords to the secret files
echo "$root_password" > secrets/mysql_root_password.txt
echo "$password" > secrets/mysql_password.txt

# Output the DATABASE_URL with correct variable substitution
echo "mysql://spectrumuser:${password}@database:3306/spectrum?serverVersion=8.0&charset=utf8mb4" > secrets/database_url.txt

# Set secure permissions for the secrets files
chmod 600 secrets/*
```

2) After run this commands :

```
cd spectrum_back
docker-compose up
```
Wait the building of the containers and open http://localhost:8000/api in web browser.

3) Run the last command to stop the Docker containers.
```
docker-compose down --remove-orphans 
```

