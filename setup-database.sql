drop table if exists Drinks;

create table Drinks (
    id int primary key auto_increment,
    name_of_drink varchar(255) NOT NULL,
    descripton varchar(255),
    price decimal(10,2),
    rating decimal(10,2),
    likes int default 0
);

create table Users (
    id int primary key auto_increment,
    admin_flag boolean default false,
    username varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    user_password varchar(255) NOT NULL,
    liked_drink_id int,
    age int,
    gender varchar(255),
    foreign key (liked_drink_id) references Drinks(id)
);


create table UserLikes (
    id int primary key auto_increment,
    user_id int,
    drink_id int,
    foreign key (user_id) references Users(id),
    foreign key (drink_id) references Drinks(id)
);










insert into Drinks ( name_of_drink, descripton, price, rating) values ( "Coke", "A fizzy drink", 1.50, 4.50);
insert into Drinks ( name_of_drink, descripton, price, rating) values ( "Pepsi", "Another fizzy drink", 1.50, 4.50);
insert into Drinks ( name_of_drink, descripton, price, rating) values ( "Fanta", "Yet another fizzy drink", 1.50, 4.50);