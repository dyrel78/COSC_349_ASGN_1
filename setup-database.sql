drop table if exists UserLikes;
drop table if exists Users;
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

-- create table DrinkOfTheWeek (
--     id int primary key auto_increment,
--     drink_id int,
--     foreign key (drink_id) references Drinks(id)
-- );


-- Dummy data sources from ChatGPT--


INSERT INTO Drinks (name_of_drink, descripton, price, rating, likes) VALUES
('Mojito', 'A classic cocktail for a party using fresh mint, white rum, sugar, zesty lime and cooling soda water.', 8.50, 4.70, 0),
('Strawberry Daquiri', 'A tasty cold cocktail using rum, sugar and frozen strawberries ', 7.00, 4.50, 0),
('Espresso Martini', 'A sophisticated cocktail made with vodka, espresso, coffee liqueur, and a sugar rim.', 9.00, 3.30, 0),
('Pina Colada', 'A tropical cocktail made with rum, coconut cream, and pineapple juice.', 10.00, 4.60, 0),
('Old Fashioned', 'A classic whiskey cocktail made with bourbon, sugar, bitters, and a twist of orange.', 6.50, 4.40, 0),
('Margarita', 'A popular Mexican cocktail made with tequila, lime juice, and triple sec.t', 9.00, 4.80, 0)
;

INSERT INTO Users (admin_flag, username, email, user_password, liked_drink_id, age, gender) VALUES
(false, 'john_doe', 'john@example.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq', 1, 28, 'male'), -- 1
(false, 'jane_doe', 'jane@example.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq', 2, 25, 'female'), -- 2
(false, 'sam_smith', 'sam@example.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq', 3, 30, 'male'), -- 3
(true, 'admin_user', 'admin@example.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq', NULL, 35, 'female'), -- 4
(false, 'alex_jones', 'alex@example.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq', 4, 40, 'male'), -- 5
(false, 'chris_lee', 'chris@example.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq', 5, 22, 'female'), -- 6
(false, 'sarah_brown', 'sarah@example.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq',1,18,'female'), -- 7
(false, 'mike_brown', 'mike@examples.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq',1,20,'female'),
(false, 'joe_brown', 'joe@examples.com', '$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq',6,55,'other'),
(false, 'peter_parker','peter@examples.com','$2y$10$3Dp.G0HaGLTZJ59tPQ1/KOcUR3RBvJEtiFKErtkmNpzWzTfbAAvzq',5,45,'other')
; -- 8




-- Insert dummy data into UserLikes table
INSERT INTO UserLikes (user_id, drink_id) VALUES
(1, 1),  -- John Doe likes 
(2, 2),  -- Jane Doe likes 
(3, 3),  
(5, 5),  -- Alex Jones likes 
(6, 6),  -- Chris Lee likes 
(7, 1),  -- Sarah Brown likes 
(8, 1),
(9,6),
(10,5); 
;


-- Update the likes column in the Drinks table
UPDATE Drinks d
SET d.likes = (
    SELECT COUNT(*)
    FROM UserLikes ul
    WHERE ul.drink_id = d.id
);




DROP TRIGGER IF EXISTS increment_likes;
DROP TRIGGER IF EXISTS decrement_likes;

-- Trigger to increment the likes column in the Drinks table

DELIMITER //

CREATE TRIGGER increment_likes
AFTER INSERT ON UserLikes
FOR EACH ROW
BEGIN
    UPDATE Drinks
    SET likes = likes + 1
    WHERE id = NEW.drink_id;
END;
//
DELIMITER ;

--  Trigger to decrement the likes column in the Drinks table
DELIMITER //

CREATE TRIGGER decrement_likes
AFTER DELETE ON UserLikes
FOR EACH ROW
BEGIN
    UPDATE Drinks
    SET likes = likes - 1
    WHERE id = OLD.drink_id;
END;
//

DELIMITER ;

