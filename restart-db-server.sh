#!/bin/bash

# Adapted from https://altitude.otago.ac.nz/cosc349/vagrant-multivm
# Original Author: David Eyers

# Update Ubuntu software packages.
apt-get update

# Set MySQL root password for non-interactive installation
export MYSQL_PWD='root_password'
echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections

# Install the MySQL database server
apt-get -y install mysql-server

# Start MySQL service
service mysql start

# Configure MySQL settings using the root user
echo "SET GLOBAL log_bin_trust_function_creators = 1;" | mysql


echo "GRANT ALL PRIVILEGES ON *.* TO 'webuser'@'%';" | mysql

# Reload privileges to make sure they take effect
echo "FLUSH PRIVILEGES;" | mysql

# Import setup-database.sql to create tables or seed data
cat /vagrant/setup-database.sql | mysql -uwebuser -ppassword drinksDB

# Update MySQL configuration to allow remote connections
sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf

# Restart MySQL service to apply changes
service mysql restart
