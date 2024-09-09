# Drink of the week 

### By Dyrel Lumiwes
This is a web application that allows bar staff to monitor which drinks are preferred by customers and which ones are not using a voting system. Each voter is only allowed to vote once for their favourite drink. The application also allows the admin staff to manage the database and update drinks available in the bar.

Technologies used: Vagrant, Docker, MySQL, HTML, CSS, Shell, PHP

<br>

## Architecture of the project

This repository consists of 3 Virtual Machine's (VM) which are provisioned using Vagrant. However, there is also a docker image containing the web application. This enables arm64 CPU architecture to run the application.

The VM's are all connected to an internal network with the following IP address 192.168.2.xx. This enables them to communicate with each other and the host machine. The web application is hosted on the user interface VM and can be accessed by the host machine on port 8080. The database is hosted on the database VM and can be accessed by the user interface VM and the admin interface VM. The admin interface VM is used to manage the database and can be accessed by the host machine on port 8081.

The VM's and their IP addresses are as follows:

* User interface - 192.168.2.11
* Database - 192.168.2.12
* Admin interface - 192.168.2.13


  <br>


## VM 1 - User Interface

This VM is used to run the voter web interface and allow users to interact with the system.

Users can create an account, log in view the drinks available, vote for their favourite drink, and view the current drink of the week.

<br>

## VM 2 - Database

This VM is used to run the MySQL database and store the data for the application. It contains 3 tables: Drinks, Users, and UserLikes.

* Drinks - Contains the details of each drink available in the bar.
* Users - Contains the details of each user who has created an account.
* UserLikes - Contains the details of each user who has voted for a drink.

<br>

## VM 3 - Admin Interface

The admin interface allows admin staff a more privileged access system to the application. Admin staff view drinks stats by a variety of different metrics, add new drinks to the database, and delete drinks from the database.


<br>

# How to run the application:
* Firstly, make sure you have downloaded Docker Desktop and Vagrant and the former is running


To get started, open terminal

1. Download or clone the repository:
```
git clone https://github.com/dyrel78/COSC_349_ASGN_1.git
```

2. In your terminal, navigate to the directory of the repository:
```
cd your/path/to/COSC_349_ASGN_1
```

3. Run the following vagrant commands to start the VM .
```
vagrant up
```

4. Open your web browser and in the url bar, paste the following link:

Using as a voter
```
localhost:8080
OR
127.0.0.1:8080
```

Using as admin staff
```
localhost:8081
OR
127.0.0.1:8081

```

</br>


### <ins> Accessing the Virtual Machines </ins>

Accessing each of the virtual machines can be done via the vagrant ssh <container_name> command. For example
```
vagrant ssh webserver
```

```
vagrant ssh adminserver
```

```
vagrant ssh dbserver
```


</br>



### <ins> Removing the Virtual Machines/Containers </ins>

```
vagrant destroy
```
</br>


### <ins>Changing admin/voter provisions scripts  - Keeps data persistent</ins>

Use these commands to change the source code in the /admin and /voter folders. This will not delete any updates made to the database.
  ```
vagrant provision webserver --provision-with restart
vagrant provision adminserver --provision-with restart
 ```
</br>


### <ins> Command to see effects of changing the Vagrantfile </ins>


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

<br>

### <ins>Accesing the database via the command line</ins>

```ruby
vagrant ssh dbserver 
export MYSQL_PWD='root_password'
mysql -u root
```



</br>

### <ins>Finding and killing address in use</ins>

* `lsof -i tcp:8080`

Once you have the PID (Process ID) use:

* `kill -9 <PID>`





## Dummy Data

The setup-database.sql file contains the schema and dummy data for the database. The database consists of 3 tables: Drinks, Users, and UserLikes. The schema for each table is as follows:

### Drinks Table

| Name of Drink | Description                                              | Price | Rating | Likes |
|---------------|----------------------------------------------------------|-------|--------|-------|
| Mojito        | A classic cocktail for a party using fresh mint, white rum, sugar, zesty lime and cooling soda water. | 8.50 | 4.70 | 0 |
| Strawberry Daquiri | A tasty cold cocktail using rum, sugar and frozen strawberries | 7.00 | 4.50 | 0 |
| Espresso Martini | A sophisticated cocktail made with vodka, espresso, coffee liqueur, and a sugar rim. | 9.00 | 3.30 | 0 |
| Pina Colada | A tropical cocktail made with rum, coconut cream, and pineapple juice. | 10.00 | 4.60 | 0 |
| Old Fashioned | A classic whiskey cocktail made with bourbon, sugar, bitters, and a twist of orange. | 6.50 | 4.40 | 0 |
| Margarita | A popular Mexican cocktail made with tequila, lime juice, and triple sec. | 9.00 | 4.80 | 0 |


### Users Table

| Admin Flag | Username    | Email              | Password     | Liked Drink ID | Age | Gender |
|------------|-------------|--------------------|--------------|----------------|-----|--------|
| false      | john_doe    | john@example.com   | password  | 1              | 28  | male   |
| false      | jane_doe    | jane@example.com   | password  | 2              | 25  | female |
| false      | sam_smith   | sam@example.com    | password  | 3              | 30  | male   |
| true       | admin_user  | admin@example.com  | password | NULL           | 35  | female |
| false      | alex_jones  | alex@example.com   | password  | 4              | 40  | male   |
| false      | chris_lee   | chris@example.com  | password  | 5              | 22  | female |
| false      | sarah_brown | sarah@example.com  | password  | 1              | 18  | female |
| false      | mike_brown  | mike@example.com   | password  | 1              | 20  | female |
| false      | joe_brown   | joe@examples.com   | password     | 6              | 55  | other  |
| false      | peter_parker| peter@examples.com | password     | 5              | 45  | other  |


### UserLikes Table

| User ID | Drink ID |
|---------|----------|
| 1       | 1        |
| 2       | 2        |
| 3       | 3        |
| 5       | 5        |
| 6       | 6        |
| 7       | 1        |
| 8       | 1        |
| 9       | 6        |
| 10      | 5        |





