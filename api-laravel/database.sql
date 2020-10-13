CREATE DATABASE IF NOT EXISTS buscadorincidencias;
USE buscadorincidencias;

CREATE TABLE users(
id 		int(255) auto_increment not null,
email varchar(255),
role	varchar(20),
name	varchar(255),
surname	varchar(255),
password varchar(255),
created_at datetime DEFAULT NULL,
updated_at datetime DEFAULT NULL,
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE incidencias(
id 		int(255) auto_increment not null,
user_id int(255) not null,
description text,
created_at datetime DEFAULT NULL,
updated_at datetime DEFAULT NULL,
CONSTRAINT pk_incidencias PRIMARY KEY(id),
CONSTRAINT fk_incidencias_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;