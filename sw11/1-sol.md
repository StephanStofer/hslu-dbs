# SW11 – Integritätssicherung
## Selbststudium
Unter dem Begriff Integrität oder Konsistenz (engl. integrity, consistency) versteht man die Widerspruchsfreiheit von Datenbeständen. Eine Datenbank ist integer oder konsistent, wenn die gespeicherten Daten fehlerfrei erfasst sind und den gewünschten Informationsgehalt korrekt wiedergeben. Die Datenintegrität ist dagegen verletzt, wenn Mehrdeutigkeiten oder widersprüchliche Sachverhalte zu Tage treten.
#### Welche 3 Arten von strukturellen Integritätsbedingungen gibt es?
##### Eindeutigkeitsbedingung
Jede Tabelle besitzt einen Identifikationsschlüssel (Primary Key), der jeder Tupel in der Tabelle auf eindeutige Art bestimmt. Das Prüfen auf Eindeutigkeit von PK's selbst wird vom DBS vorgenommen.
##### Wertebereichsbedingung
Die Merkmale einer Tabelle können nur Datenwerte aus einem vordefinierten Wertebereich annehmen. Das DBS kann nur teilweise die Bedingungen gewährleisten. Als Beispiel kann das System die Bedeutung bzw. Wahrheit einer Adresse nur bedingt prüfen oder die Länge eine VARCHAR(25) sagt auch nichts über deren Inhalt aus. Eine Alternative bieten Aufzählungstypen. Dabei werden alle Datenwerte, die das Merkmal annehmen kann, in einer Liste angegeben (zB. Jahrgang, Berufe, usw.)
##### Referenzielle Integritätsbedingung
Jeder Wert eines Fremdschlüssels muss effektiv als Schlüsselwert in der referenzierten Tabelle existieren. Dies bedeutet, dass Referenzen nur eingefügt werden können (also der FK), wenn dieser auch existiert. Dann gilt die referenzielle Integritätsbedingung. Diese Bedingung hat natürlich Einfluss auf alle Datenbankoperationen (einfügen, modifzieren, löschen). Wird ein Tupel gelöscht, welches eine Referenz als FK enthält, sind mehrere Varianten von Systemreaktionen möglich:
* Restriktive Löschung (restricted deletion); eine Löschoperation wird nicht ausgeführt, sofern andere Tupel aus der gleichen oder auch aus anderen Tabellen Referenzen auf das zu löschende Tupel zeigen.
* Fortgesetzte Löschregel (cascaded deletion); ein löschen bewirkt, dass sämtliche abhängigen Tupel auch entfernt werden. 
* Nullwerte (set null); die Werte wo Fremdschlüssel eingetragen sind werden auf «null» gesetzt.
#### Wie lautet die Definition für den Begriff «Referenzielle Integrität»?
aus Wikipedia:
> „Die referentielle Integrität (auch Beziehungsintegrität) besagt, dass Attributwerte eines Fremdschlüssels auch als Attributwert des Primärschlüssels vorhanden sein müssen.“
> „Über die referentielle Integrität werden in einem DBMS die Beziehungen zwischen Datenobjekten kontrolliert."
#### Welche 8 versch. Arten von deklarativen Integritätsbedingungen gibt es?
* Primärschlüsseldefinition (Primary Key)
* Fremdschlüsseldefinition (Foreign Key -> mit Angaben von References)
* Eindeutigkeit (Unique)
* Keine Nullwerte (Not Null)
* Prüfregel (Check)
* Ändern oder Löschen mit Nullsetzen (On Update/On Delete Set Null)
* Restriktives Ändern oder Löschen (On Update/On Delete Restrict)
* Fortgesetztes Ändern oder Löschen (On Update/On Delete Cascade)
#### Können Sie diese 8 deklarativen Integritätsbedingungen den 3 strukturellen Integritätsbedingungen zu ordnen?
##### Eindeutigkeitsbedingung
* PK
* FK
* Unique
##### Wertebereichsbedingung
* Not Null
* Check
##### Referenzielle Integritätsbedingung
* Set Null
* Restrict
* Cascade
#### Wie ist der Begriff der Transaktion definiert?
Eine Transaktion sind Datenbankoperationen welche an Integritätsregeln gebunden sind und die Datenbankzustände konsistenzerhaltend nachführen. Es ist eine Folge von Operationen die atomar, konsistent, isoliert und dauerhaft sein muss.
##### Atomarität
Eine Transaktion wird entweder komplett durchgeführt, oder sie hinterlässt keine Spuren ihrer Wirkung auf der Datenbank. Zwischenzustände sind für konkurrierende Transaktionen nicht ersichtlich. Damit bildet die Transaktion eine Einheit für die Rücksetzbarkeit nicht abgeschlossener Transaktionen.
##### Konsistenz
Eine Transaktion bewirkt das Überführen einer Daten aus einem konsistenten Zustand in einen neuen konsistenten Zustand und garantiert die Widerspruchsfreiheit der Daten. Während der Transaktion können Konsistenzbedingungen verletzt sein, bei Transaktionsende müssen diese aber erfüllt werden.
##### Isolation
Das Prinzip der Isolation verlangt, dass parallel ablaufende Transaktionen dieselben Resultate liefern wie in Einbenutzerumgebungen (Seriell). Damit bleiben die Transaktionen von ungewollten Seiteneffekten geschützt.
###### Isolationsstufen
Es gibt vier Isolationsstufen:
* Read Uncommitted; keine Konsistenzsicherung
* Read Committed; nur festgeschriebene Änderungen werden von anderen Transaktionen gelesen
* Repeatable Read; Leseanfragen geben wiederholt dasselbe Resultat
* Serializable; setzt die volle serialisierbare ACID-Konsistenz durch
##### Dauerhaftigkeit
Datenbankzustände müssen so lange gültig und erhalten bleiben, bis sie von Transaktionen verändert werden. Die Dauerhaftigkeit garantiert bei Programmfehlern, Systemabbrüchen oder Fehler auf externen Speichermedien die Wirkung einer korrekt abgeschlossener Transaktion. 
#### Transaktionen in SQL
Um eine Folge als Transaktion zu deklarieren können die Operationen mit `BEGIN TRANSACTION` und durch ein `END_OF_TRANSACTION` gekennzeichnet werden. Mit dem SQL Befehl `COMMIT` werden Änderungen festgeschrieben und allfällige Fehler können mit `ROLLBACK` vollständig widerrufen werden.
#### Erklären Sie das Prinzip der Serialisierbarkeit
Bei parallel ablaufenden Transaktionen garantiert das Prinzip der Serialisierbarkeit, dass die Resultate auf den Datenbanken identisch sind, gleichgültig ob die Transaktionen streng nacheinander ausgeführt worden sind oder nicht. Eine Menge von Transaktionen ist serialisierbar, wenn die zugehörigen Präzedenzgraphen keine Zyklen aufweisen.
#### Was ist der Unterscheid zwischen pesimistischen und optimistischen Verfahren der Serialisierung?
Die beiden Verfahren gewählrleisten die Serialisierbarkeit.
##### Pessimistische Verfahren
Pessimistische Verfahren verhindern Konflikte in parallelen Transaktionen im vorherein. Dabei nutzen sie Lock auf dem zu verändernden Objekten. Sind Locks gesetzt, müssen andere Transaktionen warten bis der Lock wieder freigegeben wird (Unlock). Alle Sperren werden im Locking Protocol festgehalten. Das _two-phase locking procotol_ grantiert die Serialisierbarkeit parallel ablaufender Transaktionen, indem nur Locks angefordert werden dürfen bis ein erster Unlock vorliegt. Danach dürfen keinen neuen Locks mehr angefodert werden. Im Sinne von Locks gibt es also eine Wachstumsphase (gemessen an Anzahl von Sperren) und eine Schrumpfphase wo die Locks wieder freigegeben werden.
##### Optimistische Verfahren
Optimistische Verfahren nehmen Konflikte in Kauf, diese werden aber im Nachhinein durch Zurücksetzen der konfliktträchtigen Transaktionen behoben. Grund dieses Verfahren einzusetzen ist, dass man davon aus geht, dass Konflikte selten vorkommen und ohne aufwendiges Sperren/Entsperren kann die Wartezeit verkürzt und die Parallelität gesteigert werden. Dieses Verfahren läuft grundsätzlich in die drei Phasen _Lese-, Validierungs- und Schreibphase_ ab. 
* Lesephase; Objekte werden gelesen und in eigenen Arbeitsbereich gespeichert und verarbeitet. Objekte können parallel gelesen werden!
* Validierungsphase; Originale werden dahingehend überprüft, ob andere Transaktionen die Objekte in der Zwischenzeit verändert haben. Falls ja wird die Transaktion zurückgestellt.
* Schreibephase; neue Daten werden committed
Die Mengen _READ_SET_ und _WRITE_SET_ müssen disjunkt sein, damit die Transaktion serialisierbar bleibt.
#### Was heisst Recovery? Welchen Zusammenhang hat es mit dem ACID-Prinzip?
Recovery bedeutet das Wiederherstellen eines korrekten Datenbankzustandes nach einem Fehlerfall. Um Transaktionen rückgängig zu machen oder zu wiederholen benötigt ein DBS gewisse Informationen. Diese werden im einer Logdatei geschrieben. Das log file enthält den Zustand des Objektes vor der Änderung (Before Image) sowie auch Marken die den Beginn (BOT = Begin of Transaction) und Ende (EOT = End of Transaction) einer Transaktion signalisieren. Weiter werden auf Anweisung von Programmen oder bei Systemereignissen _Checkpoints_ (Sicherungspunkte) gesetzt. Diese enthält eine Liste mit zu diesem Zeitpunkt aktiver Transaktionen. Mit Hilfe der Checkpoints können Rollbacks effizienter durchgeführt werden. Das DBS muss ab dem letzten Checkpoint alle Transaktionen nochmals ausführen.
## Referenzielle Integrität in SQL
#### Definieren Sie alle referentiellen Constraints als Primär- und Fremdschlüssel für die Uni-DB
```sql
select CONSTRAINT_NAME,
       TABLE_NAME,
       COLUMN_NAME,
       ORDINAL_POSITION,
       POSITION_IN_UNIQUE_CONSTRAINT,
       REFERENCED_TABLE_NAME,
       REFERENCED_COLUMN_NAME
from information_schema.KEY_COLUMN_USAGE
where CONSTRAINT_SCHEMA = 'uni4';
```
| CONSTRAINT\_NAME | TABLE\_NAME | COLUMN\_NAME | ORDINAL\_POSITION | POSITION\_IN\_UNIQUE\_CONSTRAINT | REFERENCED\_TABLE\_NAME | REFERENCED\_COLUMN\_NAME |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| PRIMARY | Professoren | PersNr | 1 | NULL | NULL | NULL |
| Raum | Professoren | Raum | 1 | NULL | NULL | NULL |
| PRIMARY | Assistenten | PersNr | 1 | NULL | NULL | NULL |
| PRIMARY | Vorlesungen | VorlNr | 1 | NULL | NULL | NULL |
| PRIMARY | hören | MatrNr | 1 | NULL | NULL | NULL |
| PRIMARY | hören | VorlNr | 2 | NULL | NULL | NULL |
| PRIMARY | voraussetzen | Vorgänger | 1 | NULL | NULL | NULL |
| PRIMARY | voraussetzen | Nachfolger | 2 | NULL | NULL | NULL |
| PRIMARY | prüfen | MatrNr | 1 | NULL | NULL | NULL |
| PRIMARY | prüfen | VorlNr | 2 | NULL | NULL | NULL |
| PRIMARY | studenten | MatrNr | 1 | NULL | NULL | NULL |
| assistenten\_ibfk\_1 | Assistenten | Boss | 1 | 1 | Professoren | PersNr |
| vorlesungen\_ibfk\_1 | Vorlesungen | gelesenVon | 1 | 1 | Professoren | PersNr |
| hören\_ibfk\_1 | hören | MatrNr | 1 | 1 | Studenten | MatrNr |
| hören\_ibfk\_2 | hören | VorlNr | 1 | 1 | Vorlesungen | VorlNr |
| voraussetzen\_ibfk\_1 | voraussetzen | Vorgänger | 1 | 1 | Vorlesungen | VorlNr |
| voraussetzen\_ibfk\_2 | voraussetzen | Nachfolger | 1 | 1 | Vorlesungen | VorlNr |
| prüfen\_ibfk\_1 | prüfen | MatrNr | 1 | 1 | Studenten | MatrNr |
| prüfen\_ibfk\_2 | prüfen | VorlNr | 1 | 1 | Vorlesungen | VorlNr |
| prüfen\_ibfk\_3 | prüfen | PersNr | 1 | 1 | Professoren | PersNr |
#### Sorgen Sie dafür, dass bei Änderungen der PK alle FK aktualisiert werden
#### table Vorlesungen
```sql
alter table Vorlesungen drop foreign key vorlesungen_ibfk_1;

alter table Vorlesungen
	add constraint vorlesungen_ibfk_1
		foreign key (gelesenVon) references Professoren (PersNr)
			on update cascade on delete set null;
```
##### table voraussetzen
```sql
alter table voraussetzen drop foreign key voraussetzen_ibfk_1;

alter table voraussetzen
	add constraint voraussetzen_ibfk_1
		foreign key (Vorgänger) references Vorlesungen (VorlNr)
			on update cascade;

alter table voraussetzen drop foreign key voraussetzen_ibfk_2;

alter table voraussetzen
	add constraint voraussetzen_ibfk_2
		foreign key (Nachfolger) references Vorlesungen (VorlNr)
			on update cascade;
```
##### table studenten
Enthält keine FKs
##### table prüfen
```sql
alter table prüfen drop foreign key prüfen_ibfk_1;

alter table prüfen
	add constraint prüfen_ibfk_1
		foreign key (MatrNr) references studenten (MatrNr)
			on update cascade;

alter table prüfen drop foreign key prüfen_ibfk_2;

alter table prüfen
	add constraint prüfen_ibfk_2
		foreign key (VorlNr) references Vorlesungen (VorlNr)
			on update cascade;

alter table prüfen drop foreign key prüfen_ibfk_3;

alter table prüfen
	add constraint prüfen_ibfk_3
		foreign key (PersNr) references Professoren (PersNr)
			on update cascade on delete set null;
```
##### Professoren
Enthält keine FKs
##### hören
```sql
alter table hören drop foreign key hören_ibfk_1;

alter table hören
	add constraint hören_ibfk_1
		foreign key (MatrNr) references studenten (MatrNr)
			on update cascade;

alter table hören drop foreign key hören_ibfk_2;

alter table hören
	add constraint hören_ibfk_2
		foreign key (VorlNr) references Vorlesungen (VorlNr)
			on update cascade;
```
##### Assistenten
```sql
alter table Assistenten drop foreign key assistenten_ibfk_1;

alter table Assistenten
	add constraint assistenten_ibfk_1
		foreign key (Boss) references Professoren (PersNr)
			on update cascade on delete set null;
```
## Statische Integrity Constraints in SQL
#### Profs können nur die Ränge C2, C3 und C4 haben
```sql
alter table Professoren
add constraint Rang CHECK (Rang in ('C2', 'C3','C4' ));
```
#### Profs haben Einzelbüros
```sql
alter table Professoren
add constraint Raum unique(Raum);
```
#### Note darf nur zwischen 1.0 und 5.0 sein
```sql
alter table prüfen
add constraint Note check ( Note >= 1.0 and Note <= 5.0 );
```
#### Name darf nicht leer sein
```sql
alter table Professoren
modify Name varchar(30) not null;
alter table studenten
modify Name varchar(30) not null;
alter table Assistenten
modify Name varchar(30) not null;
```
## Trigger
Als Vorbereitung folgendes Statement ausführen: Es soll verhindern, dass der Rang degradiert werden kann und höchstens eine Stufe erhöht wird.
```sql
DELIMITER $$
CREATE TRIGGER keineDegradierung before update on professoren FOR EACH ROW BEGIN
if (old.Rang is not null) then
if old.Rang = 'C3' and new.Rang = 'C2' then set new.Rang = 'C3'; elseif old.Rang = 'C4' then set new.Rang = 'C4';
elseif new.Rang is null
or new.Rang not in ('C2', 'C3', 'C4') then
set new.Rang = old.Rang; end if;
end if;
END $$
```
#### Testen des Triggers, prüfen ob Rang degradiert werden kann und Server reponse auswerten
Updatequery
```sql
update Professoren set Rang = 'C2' where Rang = 'C3' or Rang = 'C4';
```
Console output
```console
Query OK, 0 rows affected (0.00 sec)
Rows matched: 7  Changed: 0  Warnings: 0
```
#### Schreiben Sie einen Trigger der prüft ob Studis Vorbedingungen erfüllen (Modul mit Note <= 3.0)
```sql
delimiter $$
drop trigger if exists  checkVorbedingung;
create trigger checkVorbedingung
    before insert
    on hören
    for each row
begin
    declare vorgaengerId integer;
    declare grade integer;
    declare success boolean default true;
    declare done boolean default false;
    declare vorgaengerCursor cursor for select Vorgänger from voraussetzen where Nachfolger = New.VorlNr;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;


    open vorgaengerCursor;

    read_loop:
    LOOP
        FETCH vorgaengerCursor into vorgaengerId;
        if done then
            close vorgaengerCursor;
            leave read_loop;
        end if;
        set grade = (select Note from prüfen where VorlNr = vorgaengerId and MatrNr = new.MatrNr);
        if (grade is null or grade > 3.0)
        then
            set success = false;
        end if;
    end loop;

    if (success)
    then
        set new.MatrNr = new.MatrNr;
        set new.VorlNr = new.VorlNr;
    end if;
end
$$

```
Testquery
```sql
insert into hören values(25403,5216);
```
Console output
```console

`delimiter $$
drop trigger if exists  checkVorbedingung;
create trigger checkVorbedingung
    before insert
    on hören
    for each row
begin
    declare vorgaengerId integer;
    declare grade integer;
    declare success boolean default true;
    declare done boolean default false;
    declare vorgaengerCursor cursor for select Vorgänger from voraussetzen where Nachfolger = New.VorlNr;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;


    open vorgaengerCursor;

    read_loop:
    LOOP
        FETCH vorgaengerCursor into vorgaengerId;
        if done then
            close vorgaengerCursor;
            leave read_loop;
        end if;
        set grade = (select Note from prüfen where VorlNr = vorgaengerId and MatrNr = new.MatrNr);
        if (grade is null or grade > 3.0)
        then
            set success = false;
        end if;
    end loop;

    if (success)
    then
        set new.MatrNr = new.MatrNr;
        set new.VorlNr = new.VorlNr;
    end if;
end
$$

```
## Tansaction Isolation Levels
Isolation ist die Trennung von Transaktionen auf eine Weise, dass eine laufende Transaktion nicht von einer parallel laufenden Transaktion durch Änderung der benutzten Daten in einen undefinierten Zustand gebracht werden kann.
#### Read Uncommited
Bei dieser Isolationsebene ignorieren Leseoperationen jegliche Sperren, deshalb können die Anomalien Lost Update, Dirty Read, Non-Repeatable Read und das Phantom-Problem auftreten. Lost Updates können aber immer noch auftreten.
#### Read Committed
Diese Isolationsebene setzt für die gesamte Transaktion Schreibsperren auf Objekten, die verändert werden sollen, setzt Lesesperren aber nur kurzzeitig beim tatsächlichen Lesen der Daten ein. Daher können Non-Repeatable Read und Phantom Read auftreten, wenn während wiederholten Leseoperationen auf dieselben Daten, zwischen der ersten und der zweiten Leseoperation, eine Schreiboperation einer anderen Transaktion die Daten verändert und committed.
#### Repeatable Read
Bei dieser Isolationsebene ist sichergestellt, dass wiederholte Leseoperationen mit den gleichen Parametern auch dieselben Ergebnisse haben. Sowohl bei Lese- als auch bei Schreiboperationen werden für die gesamte Dauer der Transaktion Sperren gesetzt. Dies führt dazu, dass bis auf Phantom Reads keine Anomalien auftreten können.
#### Serializable
Die höchste Isolationsebene garantiert, dass die Wirkung parallel ablaufender Transaktionen exakt dieselbe ist wie sie die entsprechenden Transaktionen zeigen würden, liefen sie nacheinander in Folge ab. Eine Transaktion kann vom Datenbanksystem aus abgebrochen werden muss. Eine Anwendung, die mit einer Datenbank arbeitet, bei der die Isolationsebene Serializable gewählt wurde, muss daher mit Serialisationsfehlern umgehen können und die entsprechende Transaktion gegebenenfalls neu beginnen.

