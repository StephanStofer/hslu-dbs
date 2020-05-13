# SQL Cheatsheet
This cheatsheet list some useful SQL-Queries
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
