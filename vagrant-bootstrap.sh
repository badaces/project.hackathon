#!/bin/bash

apt-get clean
apt-get update

apt-get -y install ruby rubygems
gem install sass --version 3.4.9

bash /vagrant/vagrant-sync.sh