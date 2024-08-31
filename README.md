# COSC_349_ASGN_1


vagrant destroy


vagrant up

mysql -u root -p
password --> password


## Finding and killing address in use

lsof -i tcp:8080

Once you have the PID (Process ID) use:

kill -9 <PID>




## Changing Source

vagrant provision <server_name> --provision-with restart

vagrant provision webserver --provision-with restart

vagrant provision adminserver --provision-with restart


## restartgin db sql

vagrant up
vagrant ssh dbserver
cd /vagrant
echo export PS1='\[\033[0;32m\]: \w\$;\[\033[0m\] '
sudo restart_db-server.sh

### Dummy Data
Shamelessly sourced from ChatGPT
