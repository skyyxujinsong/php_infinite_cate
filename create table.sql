
-- create database
create DATABASE books;

-- create table 
create table infinite_cate
(
	id int unsigned not null auto_increment primary key,
	pid int unsigned not null,
	name char(50) not null
);
