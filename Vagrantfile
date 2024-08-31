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
    # docker.name = "ubuntu-focal"
    # Uncomment to force arm64 for testing images on Intel
    # docker.create_args = ["--platform=linux/arm64"]
  end

  # config.vm.provision :shell, :inline => <<-EOT
  #     sudo echo 'LC_ALL="en_US.UTF-8"' >> /etc/default/locale
  #     # allow services to run
  #     sudo echo exit 0 > /usr/sbin/policy-rc.d
  #     sudo chmod +x /usr/sbin/policy-rc.d
  #     sudo apt-get update
  #     sudo apt-get install -y ruby
  #     # install some commands already in Vagrant box
  #     sudo apt-get install -y less nano
  #     sudo apt install lsof
  #     sudo apt install tcpdump
  #   EOT


  # this is a form of configuration not seen earlier in our use of
  # Vagrant: it defines a particular named VM, which is necessary when
  # your Vagrantfile will start up multiple interconnected VMs. I have
  # called this first VM "webserver" since I intend it to run the
  # webserver (unsurprisingly...).
  config.vm.define "webserver" do |webserver|
    # These are options specific to the webserver VM
    webserver.vm.hostname = "webserver"
    
    # This type of port forwarding has been discussed elsewhere in
    # labs, but recall that it means that our host computer can
    # connect to IP address 127.0.0.1 port 8080, and that network
    # request will reach our webserver VM's port 80.
    webserver.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
    
    # We set up a private network that our VMs will use to communicate
    # with each other. Note that I have manually specified an IP
    # address for our webserver VM to have on this internal network,
    # too. There are restrictions on what IP addresses will work, but
    # a form such as 192.168.2.x for x being 11, 12 and 13 (three VMs)
    # is likely to work.
    webserver.vm.network "private_network", ip: "192.168.2.11"

    # This following line is only necessary in the CS Labs... but that
    # may well be where markers mark your assignment.
    # MIGHT CHANGE THIS TO /vagrant/www
    webserver.vm.synced_folder "./www/voter", "/vagrant/www/voter", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    # Now we have a section specifying the shell commands to provision
    # the webserver VM. Note that the file test-website.conf is copied
    # from this host to the VM through the shared folder mounted in
    # the VM at /vagrant
    webserver.vm.provision "shell", path: "build-webserver-vm.sh"
  end


  config.vm.define "dbserver" do |dbserver|
    dbserver.vm.hostname = "dbserver"
    # Note that the IP address is different from that of the webserver
    # above: it is important that no two VMs attempt to use the same
    # IP address on the private_network.
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
