CREATE DATABASE taskforse CHARACTER SET utf8 COLLATE utf8_general_ci;
USE taskforse;

/*
сущности таблицы taskforce
пользователь +, 
задание +,
категория задания+,
отзывы,
локация +,
отклики
*/

CREATE TABLE users (
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL,
    email varchar(64) NOT NULL UNIQUE,
    location int NOT NULL REFERENCES location(id),
    password varchar(64) NOT NULL,
    customer int,
    contact varchar(122)
);

CREATE TABLE task (
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    title varchar(122) NOT NULL,
    description varchar(255) NOT NULL,
    category int NOT NULL REFERENCES category(id),
    location int NOT NULL REFERENCES location(id),
    budget int NOT NULL,
    date_completion datetime NOT NULL,
    files varchar(255)
);

CREATE TABLE category(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(64) NOT NULL
);

CREATE TABLE location(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL UNIQUE
);

CREATE TABLE reviews(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    task int NOT NULL REFERENCES task(id),
    star int NOT NULL,
    user_id int NOT NULL REFERENCES users,
    txt varchar(255)
);

CREATE TABLE responses(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    task int NOT NULL REFERENCES task(id),
    user_id int NOT NULL REFERENCES users(id),
    txt varchar(255) NOT NULL,
    price int NOT NULL
);