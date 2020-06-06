# SQL Cheatsheet
This cheatsheet list some useful SQL-Queries
## Show scheme
```sql
show create table xy;
```
## Count(*)
Bei grossen Datenmengen kann ein Count() länger dauern. Mit folgendem Query lassen sich schnell die Anzahl Rows anzeigen:
```sql
describe select count(*) from messung;
```
## Show Foreign Key Error
Query zeigt letzten Foreign Key Error
```sql
show engine innodb status;
```
## Set User Roles
Nach Rollen müssen aktiviert werden.
*  entweder als Benutzer anmelden und `set role all;` ausgeführt werden
*  oder nach dem grant `SET DEFAULT ROLE administrator, developer TO 'joe'@'10.0.0.1';`