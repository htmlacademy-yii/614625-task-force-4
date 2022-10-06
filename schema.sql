CREATE DATABASE taskforce 
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE taskforce;

CREATE table cities(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL UNIQUE,
    longitude decimal(11,8) NOT NULL,
    latitude decimal(11,8) NOT NULL
);

CREATE TABLE users (
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL,
    email varchar(64) NOT NULL UNIQUE,
    city_id int NOT NULL,
    password varchar(64) NOT NULL,
    is_customer tinyint(1),
    telegram varchar(64) NOT NULL,
    phone varchar(64) NOT NULL,
    avatar varchar(64) NOT NULL,
    FOREIGN KEY (city_id) REFERENCES cities(id)
);

CREATE TABLE categories(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(64) NOT NULL,
    symbol_code varchar(122) NOT NULL
);

CREATE TABLE user_categories(
    id int PRIMARY KEY AUTO_INCREMENT,
    user_id int NOT NULL,
    category_id int NOT NULL REFERENCES categories(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE locations(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL UNIQUE,
    longitude decimal(11,8) NOT NULL,
    latitude decimal(11,8) NOT NULL
);

CREATE TABLE tasks (
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    title varchar(122) NOT NULL,
    description varchar(255) NOT NULL,
    category_id int NOT NULL,
    location_id int NOT NULL,
    customer_id int NOT NULL,
    executor_id int,
    status varchar(64) NOT NULL,
    budget int NOT NULL,
    date_completion datetime NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (location_id) REFERENCES locations(id),
    FOREIGN KEY (customer_id) REFERENCES users(id),
    FOREIGN KEY (executor_id) REFERENCES users(id)
);

CREATE TABLE reviews(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    task_id int NOT NULL,
    stars tinyint(5) NOT NULL,
    user_id int NOT NULL,
    text varchar(255),
    FOREIGN KEY (task_id) REFERENCES tasks(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE responses(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    task_id int NOT NULL,
    user_id int NOT NULL,
    text varchar(255) NOT NULL,
    price int NOT NULL,
    is_rejected tinyint(1),
    FOREIGN KEY (task_id) REFERENCES tasks(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE files(
    id int PRIMARY KEY AUTO_INCREMENT,
    creation_time datetime NOT NULL,
    name varchar(122) NOT NULL
);

CREATE TABLE task_files(
    id int PRIMARY KEY AUTO_INCREMENT,
    task_id int NOT NULL,
    file_id int NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id),
    FOREIGN KEY (file_id) REFERENCES files(id)
);
