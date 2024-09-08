
# Adapated from  https://altitude.otago.ac.nz/cosc349/vagrant-multivm
# Original Author: David Eyers

#!/bin/bash

sudo apt-get update
# apt-get install -y apache2 php libapache2-mod-php php-mysql lsof iputils-ping
sudo apt-get install -y apache2 php libapache2-mod-php php-mysql lsof iputils-ping
# Change VM's webserver's configuration to use shared folder.
# (Look inside test-website.conf for specifics.)
sudo cp /vagrant/user-website.conf /etc/apache2/sites-available/

# activate our website configuration ...
sudo a2ensite user-website
# ... and disable the default website provided with Apache
sudo a2dissite 000-default
# Restart the webserver, to pick up our configuration changes
sudo service apache2 restart
