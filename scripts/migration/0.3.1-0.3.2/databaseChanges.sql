alter table urls modify updated timestamp not null default current_timestamp;
update urls set updated=created;
alter table urls modify code varchar(8) not null;
