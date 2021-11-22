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