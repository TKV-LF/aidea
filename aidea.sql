create database aidea;

create table schools(
    id int not null auto_increment,
    name varchar(255) not null,
    since datetime not null,
    lastUpdate datetime not null,
    primary key(id)
);

create table roles(
    id int not null auto_increment,
    name varchar(255) not null,
    since datetime not null,
    lastUpdate datetime not null,
    primary key(id)
);

create table users(
    id int not null auto_increment,
    name varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    role_id int not null,
    school_id int not null,
    since datetime not null,
    lastUpdate datetime not null,
    primary key(id),
    foreign key(school_id) references schools(id),
    foreign key(role_id) references roles(id)
);

create table subjects(
    id int not null auto_increment,
    userId int not null,
    name varchar(255) not null,
    description varchar(255) not null,
    year int not null,
    since datetime not null,
    lastUpdate datetime not null,
    primary key(id),
    foreign key(userId) references users(id),
    index(year),
    index(name)
);

create table students(
    id int not null auto_increment,
    school_id int not null,
    name varchar(255) not null,
    since datetime not null,
    lastUpdate datetime not null,
    primary key(id),
    foreign key(school_id) references schools(id),
    index(name)
);



CREATE TABLE scores(
    id INT NOT NULL AUTO_INCREMENT,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    score FLOAT NOT NULL,
    since DATETIME NOT NULL,
    lastUpdate DATETIME NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(student_id) REFERENCES students(id),
    FOREIGN KEY(subject_id) REFERENCES subjects(id)
);


