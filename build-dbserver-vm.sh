#!/bin/bash

# Adapated from  https://altitude.otago.ac.nz/cosc349/vagrant-multivm
# Original Author: David Eyers

# Update Ubuntu software packages.
sudo apt-get update
      
# We create a shell variable MYSQL_PWD that contains the MySQL root password
export MYSQL_PWD='root_password'

# If you run the `apt-get install mysql-server` command
# manually, it will prompt you to enter a MySQL root
# password. The next two lines set up answers to the questions
# the package installer would otherwise ask ahead of it asking,
# so our automated provisioning script does not get stopped by
# the software package management system attempting to ask the
# user for configuration information.
echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections 
echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections

# Install the MySQL database server.
# apt-get -y install lsof
sudo apt-get -y install mysql-server
# On normal VMs MySQL server will now be running, but starting
# the service explicitly even if it's started causes no warnings.
# (... and it _is_ necessary for some Docker testing I'm doing)
service mysql start

## This was a workaround to allow triggers in the database
echo "SET GLOBAL log_bin_trust_function_creators = 1;" | mysql -u root

# Create the database
echo "CREATE DATABASE drinksDB;" | mysql -u root

# Create user (without GRANT)
echo "CREATE USER 'webuser'@'%' IDENTIFIED BY 'password';" | mysql -u root

# Grant privileges separately
echo "GRANT SYSTEM_VARIABLES_ADMIN ON *.* TO 'webuser'@'%';" | mysql -u root
## This was a also a workaround to allow triggers in the database
echo "GRANT SUPER ON *.* TO 'webuser'@'%';" | mysql -u root

# Grant read/write privileges on drinksDB
echo "GRANT ALL PRIVILEGES ON drinksDB.* TO 'webuser'@'%';" | mysql -u root

# Flush privileges
echo "FLUSH PRIVILEGES;" | mysql -u root

# Create admin user with strong password
echo "CREATE USER 'admin_account'@'%' IDENTIFIED BY 'strong_admin_password';" | mysql -u root
echo "GRANT SYSTEM_VARIABLES_ADMIN ON *.* TO 'admin_account'@'%';" | mysql -u root
echo "GRANT SUPER ON *.* TO 'admin_account'@'%';" | mysql -u root
echo "GRANT ALL PRIVILEGES ON drinksDB.* TO 'admin_account'@'%';" | mysql -u root

# Flush privileges again
echo "FLUSH PRIVILEGES;" | mysql -u root


# Set the MYSQL_PWD shell variable that the mysql command will
# try to use as the database password ...
export MYSQL_PWD='password'

# ... and run all of the SQL within the setup-database.sql file,
# which is part of the repository containing this Vagrantfile, so you
# can look at the file on your host. The mysql command specifies both
# the user to connect as (webuser) and the database to use (fvision).
cat /vagrant/setup-database.sql | mysql -u webuser drinksDB

# By default, MySQL only listens for local network requests,
# i.e., that originate from within the dbserver VM. We need to
# change this so that the webserver VM can connect to the
# database on the dbserver VM. Use of `sed` is pretty obscure,
# but the net effect of the command is to find the line
# containing "bind-address" within the given `mysqld.cnf`
# configuration file and then to change "127.0.0.1" (meaning
# local only) to "0.0.0.0" (meaning accept connections from any
# network interface).
sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf

# We then restart the MySQL server to ensure that it picks up
# our configuration changes.
service mysql restart
