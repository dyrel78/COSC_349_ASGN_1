# Welcome to my app - Drink of the week 

This is a web application that allows bar staff to monitor which drinks are preferred by customers and which drinks are not using a rating and voting system.



# How to use this application

* Firstly, make sure you have Docker Desktop installed and running
* Clone this repository to your local machine
* Then, navigate to the directory where the repository is stored

</br>



### <ins>Starting the application</ins>
  

`vagrant up` &rarr; This will start the application and the 3 VM's

mysql -u root -p
password --> password

</br>

### <ins>Finding and killing address in use</ins>

* `lsof -i tcp:8080`

Once you have the PID (Process ID) use:

* `kill -9 <PID>`

</br>

### <ins>Changing Source - Keeps data persistent</ins>

Use these commands to change the source code in the /admin and /voter folders. This will not delete any updates made to the database.
  ```
vagrant provision webserver --provision-with restart
vagrant provision adminserver --provision-with restart
 ```
</br>


### <ins>Changing admin/ changing provision script - Saves DB</ins>

```
vagrant reload
```  
</br>


### <ins>Restarting the database/Changing the database scheme</ins>

 ```Shell
 vagrant up 
 vagrant ssh dbserver 
 cd /vagrant
 sudo sh bash-vars.sh
 sudo sh restart-db-server.sh
 ```

<!-- #!/bin/bash
export PS1='\[\033[0;32m\]: \w\$;\[\033[0m\] '

OR  -->
<!-- * `sudo sh bash-vars.sh`

* `sudo sh restart-db-server.sh` -->

</br>


### <ins>Accesing the database via the command line</ins>

```ruby
vagrant ssh dbserver 
export MYSQL_PWD='root_password'
mysql -u root
```





## Architecture of the project

This repository consists of 3 Virtual Machine's (VM) which are provisioned using Vagrant. However, there is also a docker image containing the web application. This enables arm64 CPU architecture to run the application.



The VM's are all connected to an internal network with the following IP address 192.168.2.xx. This enables them to communicate with each other and the host machine. The web application is hosted on the user interface VM and can be accessed by the host machine on port 8080. The database is hosted on the database VM and can be accessed by the user interface VM and the admin interface VM. The admin interface VM is used to manage the database and can be accessed by the host machine on port 8081.

The VM's and their IP addresses are as follows:

* User interface - 192.168.2.11
* Database - 192.168.2.12
* Admin interface - 192.168.2.13



## Dummy Data

### Drinks Table

| Name of Drink | Description                                              | Price | Rating | Likes |
|---------------|----------------------------------------------------------|-------|--------|-------|
| Whiskey       | A strong alcoholic beverage made from grains             | 8.50  | 4.70   | 0     |
| Vodka         | A clear, distilled alcoholic beverage with a neutral flavor | 7.00  | 4.50   | 0     |
| Beer          | A refreshing beverage made from barley and hops          | 3.00  | 3.30   | 0     |
| Red Wine      | A smooth wine made from red grapes                       | 10.00 | 4.60   | 0     |
| Gin           | A distilled alcoholic drink with a prominent juniper berry flavor | 6.50  | 4.40   | 0     |
| Tequila       | A strong distilled spirit made from the agave plant      | 9.00  | 4.80   | 0     |

### Users Table

| Admin Flag | Username    | Email              | Password     | Liked Drink ID | Age | Gender |
|------------|-------------|--------------------|--------------|----------------|-----|--------|
| false      | john_doe    | john@example.com   | password123  | 1              | 28  | male   |
| false      | jane_doe    | jane@example.com   | password123  | 2              | 25  | female |
| false      | sam_smith   | sam@example.com    | password123  | 3              | 30  | male   |
| true       | admin_user  | admin@example.com  | adminpassword | NULL           | 35  | female |
| false      | alex_jones  | alex@example.com   | password123  | 4              | 40  | male   |
| false      | chris_lee   | chris@example.com  | password123  | 5              | 22  | female |
| false      | sarah_brown | sarah@example.com  | password123  | 1              | 18  | female |
| false      | mike_brown  | mike@example.com   | password123  | 1              | 20  | female |

### UserLikes Table

| User ID | Drink ID |
|---------|----------|
| 1       | 1        |
| 2       | 2        |
| 3       | 3        |




