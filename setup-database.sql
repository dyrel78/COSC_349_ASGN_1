

drop table if exists Drinks;
drop table if exists Users;
drop table if exists UserLikes;


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

-- Dummy data sources from ChatGPT--


INSERT INTO Drinks (name_of_drink, descripton, price, rating, likes) VALUES
('Whiskey', 'A strong alcoholic beverage made from grains', 8.50, 4.70, 1),
('Vodka', 'A clear, distilled alcoholic beverage with a neutral flavor', 7.00, 4.50, 1),
('Beer', 'A refreshing beverage made from barley and hops', 3.00, 3.30, 1),
('Red Wine', 'A smooth wine made from red grapes', 10.00, 4.60, 1),
('Gin', 'A distilled alcoholic drink with a prominent juniper berry flavor', 6.50, 4.40, 1);


-- Insert dummy data into Users table
INSERT INTO Users (admin_flag, username, email, user_password, liked_drink_id, age, gender) VALUES
(false, 'john_doe', 'john@example.com', 'password123', 1, 28, 'male'), -- 1
(false, 'jane_doe', 'jane@example.com', 'password123', 2, 25, 'female'), -- 2
(false, 'sam_smith', 'sam@example.com', 'password123', 3, 30, 'male'), -- 3
(true, 'admin_user', 'admin@example.com', 'adminpassword', NULL, 35, 'female'), -- 4
(false, 'alex_jones', 'alex@example.com', 'password123', 4, 40, 'male'), -- 5
(false, 'chris_lee', 'chris@example.com', 'password123', 5, 22, 'female'), -- 6
(false, 'sarah_brown', 'sarah@example.com', 'password123',1,18,'female'), -- 7
(false, 'mike_brown', 'mike@examples.com', 'password123',1,20,'female'), -- 8

-- Insert dummy data into UserLikes table
INSERT INTO UserLikes (user_id, drink_id) VALUES
(1, 1),  -- John Doe likes 
(2, 2),  -- Jane Doe likes 
(3, 3),  -- Sam Smith likes 
(5, 4),  -- Alex Jones likes 
(6, 5),  -- Chris Lee likes  
(7, 1),  -- Sarah Brown likes 
(8, 1);  -- Mike Brown likes 


