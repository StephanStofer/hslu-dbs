# SW10 – Datenbanksicherheit
## Selbststudium
#### Was heisst Datensicherheit?
Datensicherheit sind technische und softwaregestützte Massnahmen zum Schutz der Daten vor Verfälschung, Zerstörung oder Verlust.
#### Was ist der Unterscheid zwischen Datensicherheit und Datenschutz?
Unter Datenschutz versteht man den Schutz der Daten vor unbefugtem Zugriff und Gebrauch. Datensicherheit ist mit obiger Antwort erläutert.
#### Welche Rolle Spielen Sichten für die Datensicherheit?
Mittels Views können wesentliche Datenschutzmechanismen implementiert werden. Restriktionen werden insofern erreicht, da die Views nur die Tabellen und Tabellenansichten zur Verfgügung stellen, welche die berechtigten Benutzer benötigen. Die View wird auf Basis eines Select-Statements erstellt. Als Nachteil einer View könnte man anbringen, dass diese für Änderungen nicht in jedem Fall verwendet werden können. Kriterien für eine Änderbare View
* Die Sicht bezieht sich auf eine einzige Tabelle (keine Joins erlaubt).
* Diese Basistabelle hat einen Primärschlüssel
* Der definierende SQL-Ausdruck beinhaltet keine Operationen, welche die Anzahl Zeilen der Resultatmenge beeinflussen (z. B. aggregate, group by, distinct, etc.)
```sql
CREATE VIEW view-name AS <SELECT-statement>
```
#### Was heisst Grant? Was heisst Grant Option?
Grant ist die Operation um einem Benutzer oder Gruppe Privilegien wie Lese-, Einfüge-, oder Löschoperationen auf bestimmte Tabellen/Views zu vergeben. Mit Revoke können die Privilegien wieder entzogen werden.
```sql
GRANT <Privileg> ON <Tabelle> TO <Benutzer>
```
```sql
REVOKE <Privileg> ON <Tabelle> FROM <Benutzer>
```
Die Grant Option ermöglicht es der berechtigten Gruppe oder Benutzer dieses Recht, oder ein eingeschränktes Leserecht, in Eigenkompetenz weiterzugeben und auch später wieder zurückzunehmen. Mit diesem Konzept lassen sich Abhängigkeitsbeziehungen von Rechten festlegen und verwalten.
#### Was ist SQL-Injection? Wie schützt man sich davor?
Eine SQL Injection ist eine Schwachstelle in einer Applikation (Web) wodurch sich vordefinierte Datenbankabfragen (zB. Formulare) verändern lassen. Wird zum Beispiel eine BenutzerID über ein Post-Parameter übergeben, kann mit der sehr einfachen `or 1=1` eine gültige immer valide Abfrage erzeugen. 
Der beste Schutz bieten Stored Functions (Statement Sanitation, Prepared Statements) die nur typisierte Parameter erlauben.
## Externe Angriffvektoren
| Begriffe        | Definition           | Gegenmassnahmen  |
| ------------- |-------------| -----|
| Trust Security | Autom. Authentifizierungsmethode von lokalen Benutzer | Beim starten von `initdb` Flag -A verwenden -> `initdb -A` |
| Passwords Theft | Passwort Diebstahl | Schutz der Passwörter mittels seriösen Verschlüsselungsalgorithmen und random Salt |
| Network Snooping | Abhören des Netzwerkverkehrs | Verbindung mit SSL Verschlüsseln |
| Network Spoofing | Vorgauckeln des SQL-Servers (Fake) | Nutzen von Zertifikaten auf Client/Server -> verify CA |
| Server / Backup Theft | Diebstahl von / Eindringen zur Hardware | Festplatten Verschlüsseln, mechanische Zerstörung |
## Autorisierung: Views und Grants
In der Uni-DB sollen folgende Zugriffsrechte gelten:
* C4-Profs dürfen in allen Tabellen lesen und schreiben
* C3-Profs dürfen in allen Tabellen lesen und schreiben, ausser in der Tabelle «Professoren»: Diese dürfen sie nur lesen
* Assistenten dürfen alle Tabellen lesen. Schreiben dürfen Sie nur in die Tabelle Studenten
* Studenten dürfen nichts schreiben und nur folgende Tabellen Lesen: Vorlesungen und Professoren
#### Erstellen Sie die Rollen Professor, Assistent, Student und erteilen Sie die oben beschriebenen Berechtigungen mit SQL.
```sql
create role 'Professor', 'Assistent', 'Student';
grant all on * to Professor; -- don't know how to select "Rang" value
grant select on * to Assistent;
grant insert, update on Studenten to Assistent;
grant select on Vorlesungen to Student;
grant select on Professoren to Student;
```
#### Erstellen Sie Prof, Assi und Student einen Benutzer
````sql
SET @s:='';
SELECT @s:= concat(@s, 'CREATE USER ', name, ' IDENTIFIED BY "Passw0rd!";\n') as c
from(
select 'Student' as rolle, name from studenten
union select 'C4', name from professoren where Rang = 'C4' union select 'C3', name from professoren where Rang = 'C3' union select 'Assistent', name from assistenten
)a;
select @s;
```sql
GRANT 'Professor' TO 'Xenokrates';
```
#### Die Studenten sollen in der Tabelle Prüfungen nur Ihre eigenen Noten sehen können. Programmieren Sie eine Lösung
```sql
SELECT Note from prüfen inner join Studenten S on prüfen.MatrNr = S.MatrNr where s.Name = user();
```
## SQL-Injection: Programmierung
#### Auf welche weite Arten ist der Server mit SQL angreifbar? Kommen Sie an die Passwörter ran?
? Es werden alle PW ausgegeben.
#### Verhinder Sie SQL-Injection mit Hilfe eines
##### Mit einem Client Side prepared statement
```java
PreparedStatement ps = connection.prepareStatement("SELECT * from Studenten s join prüfen p on s" +
                        ".MatrNr = p.MatrNr " +
                        "Where " +
                        "s.Name = ? and s.Passwort = ?");
                ps.setString(1, user);
                ps.setString(2, pw);
                ResultSet resultset = ps.executeQuery();
```
##### Mit einem Server Side prepared statement
```sql
prepare login_statement from 'SELECT * from Studenten s join prüfen p on s.MatrNr = p.MatrNr Where s.Name = ? and s.Passwort = ?';
```
```java
```


