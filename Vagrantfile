# -*- mode: ruby -*-
# vi: set ft=ruby :

# A Vagrantfile to set up two VMs, a webserver and a database server,
# connected together using an internal network with manually-assigned
# IP addresses for the VMs.

VAGRANTFILE_API_VERSION = "2"


Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/focal64"
  config.vm.provider :docker do |docker, override|
    override.vm.box = nil
    #docker.image = "ubuntu:focal"
    docker.image = "dme26/vagrant-provider:ubuntu-focal"
    docker.remains_running = true
    docker.has_ssh = true
    docker.privileged = true
    docker.volumes = ["/sys/fs/cgroup:/sys/fs/cgroup:rw"]
    docker.create_args = ["--cgroupns=host","-h ubuntu-focal.testdomain"]

    # Uncomment to force arm64 for testing images on Intel
    # docker.create_args = ["--platform=linux/arm64"]
  end

  config.vm.define "webserver" do |webserver|
    webserver.vm.hostname = "webserver"
    
    # This means that our host computer can
    # connect to IP address 127.0.0.1 port 8080, and that network
    # request will reach our webserver VM's port 80.
    webserver.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
    webserver.vm.network "private_network", ip: "192.168.2.11"
    webserver.vm.synced_folder "./www/voter", "/vagrant/www/voter", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]
    webserver.vm.provision "shell", path: "build-webserver-vm.sh"
  end


  config.vm.define "dbserver" do |dbserver|
    dbserver.vm.hostname = "dbserver"
    dbserver.vm.network "private_network", ip: "192.168.2.12"
    dbserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]
    
    dbserver.vm.provision "shell", path: "build-dbserver-vm.sh"
  end


  config.vm.define "adminserver" do |adminserver|
    adminserver.vm.hostname = "adminserver"
    adminserver.vm.network "forwarded_port", guest: 80, host: 8081, host_ip: "127.0.0.1"
    adminserver.vm.network "private_network", ip: "192.168.2.13"
    adminserver.vm.synced_folder "./www/admin", "/vagrant/www/admin", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]
    adminserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]
    adminserver.vm.provision "shell", path: "build-adminserver-vm.sh"
  end

  

# Script taken from https://altitude.otago.ac.nz/cosc412/demo-vm/-/tree/docker?ref_type=heads
  config.vm.provision :shell, :inline => <<-EOT
     echo 'LC_ALL="en_US.UTF-8"' >> /etc/default/locale
     # allow services to run
     echo exit 0 > /usr/sbin/policy-rc.d
     chmod +x /usr/sbin/policy-rc.d
     apt-get update
     apt-get install -y ruby
     # install some commands already in Vagrant box
     apt-get install -y less nano
  EOT


end

#  LocalWords:  webserver xenial64
