create table people (
	id        int unsigned not null primary key auto_increment,
	firstname varchar(128) not null,
	lastname  varchar(128) not null,
	email     varchar(128) unique,
	username  varchar(40)  unique,
	password  varchar(40),
	role      varchar(30),
	authentication_method varchar(40)
);


create table urls (
	id        int unsigned not null primary key auto_increment,
	person_id	  int unsigned not null,
	code	varchar(6) not null,
	original	varchar(128) not null,
	foreign key(person_id) references people(id)
);