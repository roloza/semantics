# Semantics
Analyse la sémantique des contenus

## Installation
```
composer install
```

### VHOST
```
sudo ln -s /var/www/sites/semantics/host/semantics.conf /etc/nginx/sites-enabled/semantics.conf
sudo ln -s /var/www/sites/semantics/host/semantics.conf /etc/nginx/sites-available/semantics.conf

sudo service nginx restart

sudo chown -R www-data:www-data /var/www/sites/semantics/sites/semantics/storage
sudo chown -R www-data:www-data /var/www/sites/semantics/sites/semantics/vendor
Sudo usermod -a -G www-data roloza
```

### Migrations
```
php artisan migrate:refresh
php artisan migrate:refresh --seed

php artisan db:seed

php artisan db:seed --class=TypeSeeder
php artisan db:seed --class=StatusSeeder
php artisan db:seed --class=CatGrammaticalSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=SynonymSeeder
php artisan db:seed --class=AntonymSeeder
php artisan db:seed --class=LexiqueSeeder
php artisan db:seed --class=ProfileSeeder

php artisan db:seed --class=PostSeeder

```

### Création lien symbolique
```
php artisan storage:link
```

### MongoDb
```
sudo apt install pecl
sudo apt install php-dev php-pear
sudo pecl install mongodb

sudo echo "extension=mongodb.so" > /etc/php/8.0/cli/php.ini
ou
sudo nano /etc/php/8.0/cli/php.ini AND add "extension=mongodb.so"
```

### Resources
```
Dezipper "resources/storage-resources.zip" dans le dossier "storage/app" du projet
Copier "auditfactory-syntex.sh" dans "/usr/local/scripts/bash"
Copier "https://github.com/roloza/syntex" dans "/usr/local/syntex3"
Copier "https://github.com/roloza/treetagger" dans "/usr/local/treetagger"
```