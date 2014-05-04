CREATE DATABASE stream_send;

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, CREATE TEMPORARY TABLES ON stream_send.* TO stream_admin@localhost IDENTIFIED BY '<redacted>'; 

CREATE TABLE stream_send.users (
	id int NOT NULL auto_increment PRIMARY KEY,
	email varchar(255) NOT NULL default '',
	password varchar(65) NOT NULL default '',
	first_name varchar(255) NOT NULL default '',
	last_name varchar(255) NOT NULL default '',
	salt varchar(34)
) ENGINE=InnoDB;
