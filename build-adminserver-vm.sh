
# Adapated from  https://altitude.otago.ac.nz/cosc349/vagrant-multivm
# Original Author: David Eyers

sudo apt-get update
sudo apt-get install -y apache2 php libapache2-mod-php php-mysql

sudo cp /vagrant/admin-website.conf /etc/apache2/sites-available/

sudo a2ensite admin-website
sudo a2dissite 000-default
sudo service apache2 restart
