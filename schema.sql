CREATE DATABASE taskforse CHARACTER SET utf8 COLLATE utf8_general_ci;
USE taskforse;

CREATE TABLE users (
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL,
    email varchar(64) NOT NULL UNIQUE,
    city_id int NOT NULL REFERENCES cities(id),
    password varchar(64) NOT NULL,
    is_customer tinyint(1),
    telegram varchar(64) NOT NULL,
    phone varchar(64) NOT NULL,
    avatar varchar(64) NOT NULL,
    category_id int NOT NULL REFERENCES categories_user(id)
);

CREATE table cities(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL UNIQUE,
    width decimal(11,8) NOT NULL,
    latitude decimal(11,8) NOT NULL
);

CREATE TABLE tasks (
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    title varchar(122) NOT NULL,
    description varchar(255) NOT NULL,
    category_id int NOT NULL REFERENCES category(id),
    location_id int NOT NULL REFERENCES location(id),
    customer_id int NOT NULL REFERENCES users(id),
    executor_id int NOT NULL REFERENCES users(id),
    status varchar(64),
    budget int NOT NULL,
    date_completion datetime NOT NULL
);

CREATE TABLE categories(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(64) NOT NULL
);

CREATE TABLE categories_user(
    id int PRIMARY KEY AUTO_INCREMENT,
    user_id int NOT NULL REFERENCES users(id),
    category int NOT NULL REFERENCES categories(id)
);

CREATE TABLE locations(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL UNIQUE,
    width decimal(11,8) NOT NULL,
    latitude decimal(11,8) NOT NULL
);

CREATE TABLE reviews(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    task int NOT NULL REFERENCES task(id),
    stars tinyint(5) NOT NULL,
    user_id int NOT NULL REFERENCES users(id),
    text varchar(255)
);

CREATE TABLE responses(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    task_id int NOT NULL REFERENCES task(id),
    user_id int NOT NULL REFERENCES users(id),
    text varchar(255) NOT NULL,
    price int NOT NULL,
    is_rejected tinyint(1)
);

CREATE TABLE files(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL
);

CREATE TABLE task_files(
    id int PRIMARY KEY AUTO_INCREMENT,
    task_id int NOT NULL REFERENCES task(id),
    file_id int NOT NULL REFERENCES files(id)
);
