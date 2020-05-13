# Doku
##Installation
wizard.. blabla
##login
## ERstellung DB
```sql
CREATE DATABASE dbs;
```
```console
mysql> CREATE DATABASE dbs;
Query OK, 1 row affected (0.01 sec)
```
Kontext wechseln
```sql
USE dbs;
```
```console
Database changed
```
Prüfen ob Tabellen vorhanden sind:
```sql
SHOW TABLES;
```
```console
Empty set (0.00 sec)
```
## Rollen/USer
```sql
CREATE ROLE 'webuser';
GRANT SELECT ON dbs.* TO 'webuser';
CREATE USER 'php_user'@'localhost' IDENTIFIED BY 'lassie-bunch-mentor';
GRANT 'webuser' TO 'php_user'@'localhost';
```
## Erstellung Tables
### groesse
```sql
create table groesse
(
	id char(38) not null,
	kuerzel varchar(20) null,
	name varchar(255) null,
	einheit varchar(20) null,
	constraint groesse_id_uindex
		unique (id)
);

alter table groesse
	add primary key (id);

create definer = sa_dbs@`%` trigger init_uuid_groesse
	before insert
	on groesse
	for each row
	SET NEW.id = UUID();
```
### ort
```sql
create table ort
(
	id char(38) not null,
	ortschaft varchar(256) null,
	constraint ort_id_uindex
		unique (id)
);

alter table ort
	add primary key (id);

create definer = sa_dbs@`%` trigger init_uuid_ort
	before insert
	on ort
	for each row
	SET NEW.id = UUID();
```
### messung
```sql
create table if not exists messung
(
	id char(38) not null,
	datum datetime not null,
	wert decimal null,
	ort_id char(38) null,
	groesse_id char(38) null,
	constraint messung_id_uindex
		unique (id),
	constraint fk_messung_groesse
		foreign key (groesse_id) references groesse (id),
	constraint fk_messung_ort
		foreign key (ort_id) references ort (id)
);

alter table messung
	add primary key (id);

create definer = sa_dbs@`%` trigger init_uuid_messung
	before insert
	on messung
	for each row
	SET NEW.id = UUID();
```
