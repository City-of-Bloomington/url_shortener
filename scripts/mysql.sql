create table urls (
	id        int unsigned not null primary key auto_increment,
	username  varchar(40)  not null,
	code	  char(5)      not null unique,
	original  text         not null,
	created   datetime     not null default CURRENT_TIMESTAMP,
	updated   timestamp    not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
);
