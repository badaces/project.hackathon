# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "avenuefactory/lamp"
  config.vm.network "forwarded_port", guest: 80, host: 8082
  config.vm.network "public_network"
  config.vm.provision :shell, :path => "vagrant-sync.sh"

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--memory", "2048"]
  end
end
