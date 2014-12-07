#!/bin/sh

echo 'Removing /var/www/html/*'
sudo rm -rf /var/www/html/*

echo 'Copying application files'
sudo cp -RT /vagrant /var/www/html

echo 'Updating permissions'
sudo chown -R vagrant:vagrant /var/www/html

echo 'Ensuring vagrant-sync is executable'
sudo chmod +x /var/www/html/vagrant-sync.sh

echo 'Compiling scss to css'
sass --update -f /var/www/html/web/sass/:/var/www/html/web/css

cd /var/www/html

echo 'Migrating database'
bin/phinx migrate

echo 'Importing data'
php app/console.php import:temperature_data
php app/console.php import:methane_data
php app/console.php import:co2_data
