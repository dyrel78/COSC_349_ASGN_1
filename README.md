# Drink of the week 

vagrant destroy


vagrant up

mysql -u root -p
password --> password


## Finding and killing address in use

* `lsof -i tcp:8080`

Once you have the PID (Process ID) use:

* `kill -9 <PID>`




## Changing Source

vagrant provision <server_name> --provision-with restart

* `vagrant provision webserver --provision-with restart`

* `vagrant provision adminserver --provision-with restart`


## Changing admin/ changing provision script
* `vagrant reload --provision`    

## restarting db vm when modiiying the SQL directly

* `vagrant up`

* `vagrant ssh dbserver`

* `cd /vagrant`

#!/bin/bash
export PS1='\[\033[0;32m\]: \w\$;\[\033[0m\] '

OR 
* `sudo sh bash-vars.sh`

* `sudo sh restart-db-server.sh`



## Accesing the database


`vagrant ssh dbserver `

`export MYSQL_PWD='root_password'`

`mysql -u root`


### Dummy Data
Shamelessly sourced from ChatGPT


