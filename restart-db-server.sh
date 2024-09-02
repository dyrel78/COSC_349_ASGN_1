# apt-get update
# export MYSQL_PWD='password_root'
# # echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections 
# # echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections
# service mysql start
# export MYSQL_PWD='password'

# cat /vagrant/setup-database.sql | mysql -u webuser drinksDB
# sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf
# # We then restart the MySQL server to ensure that it picks up
# # our configuration changes.
# service mysql restart

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
# mysql -uroot -p$MYSQL_PWD -e "SET GLOBAL log_bin_trust_function_creators = 1;"
echo "SET GLOBAL log_bin_trust_function_creators = 1;" | mysql

# mysql -uroot -p$MYSQL_PWD -e "CREATE DATABASE drinksDB;"
# mysql -uroot -p$MYSQL_PWD -e "CREATE USER 'webuser'@'%' IDENTIFIED BY 'password';"

echo "GRANT ALL PRIVILEGES ON *.* TO 'webuser'@'%';" | mysql
# mysql -uroot -p$MYSQL_PWD -e "GRANT ALL PRIVILEGES ON drinksDB.* TO 'webuser'@'%';"

# Instead of granting SUPER, use SYSTEM_VARIABLES_ADMIN if available 
# mysql -uroot -p$MYSQL_PWD -e "GRANT SYSTEM_VARIABLES_ADMIN ON *.* TO 'webuser'@'%';"

# Reload privileges to make sure they take effect
# mysql -uroot -p$MYSQL_PWD -e "FLUSH PRIVILEGES;"
echo "FLUSH PRIVILEGES;" | mysql

# Import setup-database.sql to create tables or seed data
cat /vagrant/setup-database.sql | mysql -uwebuser -ppassword drinksDB

# Update MySQL configuration to allow remote connections
sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf

# Restart MySQL service to apply changes
service mysql restart
