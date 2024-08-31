apt-get update
export MYSQL_PWD='password_root'
# echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections 
# echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections
service mysql start
export MYSQL_PWD='password'
cat /vagrant/setup-database.sql | mysql -u webuser drinksDB
sed -i'' -e '/bind-address/s/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf
# We then restart the MySQL server to ensure that it picks up
# our configuration changes.
service mysql restart