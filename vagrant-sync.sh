#!/bin/sh

echo 'Removing /var/www/html/*'
sudo rm -rf /var/www/html/*

echo 'Copying application files'
sudo cp -RT /vagrant /var/www/html

echo 'Updating permissions'
sudo chown -R vagrant:vagrant /var/www/html

echo 'Ensuring vagrant-sync is executable'
sudo chmod +x /var/www/html/vagrant-sync.sh
