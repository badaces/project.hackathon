#!/bin/bash

apt-get clean
apt-get update

apt-get -y install ruby rubygems
gem install sass --version 3.4.9

apt-get -y install php5-curl

service apache2 restart

mysqladmin -u root -proot create hackathon

bash /vagrant/vagrant-sync.sh