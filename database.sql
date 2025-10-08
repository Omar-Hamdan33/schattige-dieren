DROP DATABASE IF EXISTS animals;
create database animals;
use animals;

create table animal
(
Id Int primary KEY auto_increment,
Name Varchar(50),
);
insert into animal ( Name) values 
('dog', false),
('cat', false),
('cow', false),
('duck', false),
('elephant', false),
('goat', false),
('horse', false),
('pig', false),
('seal', false),

select * from animal;
