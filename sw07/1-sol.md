#SW07 - SQL Performance
## Selbststudium
#### Welche der Schichten der Datenbankarchitektur sind für die Anfrageoptimierung relevant, und weshalb?
##### Schicht1: Mengenorientierte Schnittstelle
Es werden Datenstrukturen beschrieben, Operationen auf Mengen bereitgestellt (Relationenalgebra/Kalkül), Zugiffsbedingungen geprüft und Konsistenzanforderungen geprüft. Weiter wird die Syntax geprüft, Namen aufgelöst und Zugriffspfade ausgewählt werden. Bei der Wahl der Zugriffspfade können wesentliche Optimierungen vorgenommen werden.
##### Schicht2: Satzorientierte Schnittstelle
Diese Schicht überführt logische Sätze und Zugriffspfade in physische Strukturen. Mit Hilfe der Transaktionenverwaltung wird die Konsistenz gewährleistet. Das Cursorkonzept erlaubt das Navigieren oder Durchlaufen von Datensätzen nach der physischen Speicherungsreiehenfolge, das Positionieren bestimmter Datensätze innerhalb einer Tabelle oder Bereitstellen von Datensätzen in wertabhängiger Sortierreihenfolge.
##### Schicht3: Speicher- und Zugriffsstrukturen
Die dritte Schicht implementiert physische Datensätze und Zugriffspfade auf Pages. Speicherstrukturen (Baum-, Hash) sind so ausgelegt, dass die den Zugriff auf externe Speichermedien effizient bewerkstelligen. Physische Cluster oder mehrdimensionale Zugriffpfade können weitere Optimierungen erzielen.
##### Schicht4: Seitenzuordnung
Zur Effizienzsteigerung und Recovery-Verfahren unterteilt diese schicht den linearen Adressraum in sogenannte Segmente mit einheitlichen Seitengrenzen. Je nach Dateiverwaltung können in einem Puffer Seiten bereitgestellt werden. Welche auch aktualisiert werden können. Neben der direkten gibt es auch die indirekte Zuordnunge wie Schattenspeicher- oder Cacheverfahren. Dadurch lassen sich mehrere Sieten atomar in den Puffer einbringen.
##### Schicht5: Speicherzuordnung
Realisiert die Speicherzuordnungsstrukturen und bietet der Schicht 4 eine blockorientierte Dateiverwaltung. HW-Eigenschaften bleiben verborgen. Unterstützt normalerweise dynamisch wachsende Dateien mit definierbaren Blockgrössen.
#### Wie wirkt sich ein Index auf die Leistung des Nested Join (Verschachtelter Verbund) aus?
Sind Strukturen sortiert, ist die Laufzeit linear. Das entspricht einem grossen Performancegewinn.
#### Was ist ein B-Baum, und wozu dient er im Zusammenhang mit der Anfrageoptimierung?
Ein B-Baum ist ein sogenannter blattorientierter Mehrwegbaum. Daten werden in einer Baumstruktur gespeichert. Um aufwändige Seitezugriffe zu umgehen wächst der B-Baum eher in die Breite, anstatt in die Tiefe. Ein B-Baum hat min. n Teilbäume und maximal 2*n Elemente bzw. auch Teilbäume. Mit der Baumstruktur können schnelle Zugriffe auf Daten gewährleistet werden.
#### Warum ist eine Query, welche mit Map-Reduce parallelisiert wird, schneller, als wenn sie sequenziell bearbeitet wird?
Eine Aufgabe wird in mehrere Teilaufgaben und auf versch. Rechner verteilt. Nach der Verarbeitung werden die Teilresultate gesammelt und zentral ausgewertet.
## Interaktion mit der Datenbank
Lokal wird eine Datenbank mit einer grösseren Anzahl Datensätzen erstellt.
#### Selektieren Sie eine Studentin über die Matrikelnummer. Wie lange dauert die Anfrage?
```sql
Use moreUniData2;
select * from moreStudenten where MatrNr = 1012345;
```
Die Anfrage dauert bei 10 Abfragen zwischen 23-33ms
#### Selektieren Sie die gleiche Studentin über den Namen
```sql
select * from moreStudenten where Name = 'Studentin_12345';
```
Die Anfrage dauert bei 10 Abfragen zwischen 193-203ms
#### Wie viel länger dauert welche Query? Wie erklären Sie sich diesen Unterschied?
Die Abfrage über den Namen dauert 6 bis 7 mal länger als über die Matrikel-Nr. Die Matrikel-Nr ist gleichzeitig PrimaryKey und damit automatisch indexiert. Evtl. könnte zudem ein Zahlenvergleich effizienter als ein Stringvergleich sein?
##Query Execution Plan
Syntax zu erstellen eines Ausführungsplans
```sql
EXPLAIN <query>;
EXPLAIN select * from Professoren;
```
#### Zeigen Sie den Explain Plan für die beiden vorherigen Anfragen an. Vergleichen Sie
```sql
Explain select * from moreStudenten where MatrNr = 1012345;
```
| id | select\_type | table | partitions | type | possible\_keys | key | key\_len | ref | rows | filtered | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | SIMPLE | moreStudenten | NULL | const | PRIMARY | PRIMARY | 4 | const | 1 | 100 | NULL |
```sql
EXPLAIN select * from moreStudenten where Name = 'Studentin_12345';
```
| id | select\_type | table | partitions | type | possible\_keys | key | key\_len | ref | rows | filtered | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | SIMPLE | moreStudenten | NULL | ALL | NULL | NULL | NULL | NULL | 996887 | 10 | Using where |
Bei der Abfrage über den Namen wurden beinahe 1Mio. Rows geprüft (mit Where), bei der Abfrage via Matrikelnummer lediglich eine. Weiter sagt und die Spalte filtered, dass mit der Abfrage zu 100 bzw. 10% eingeschränkt wurde. Was bei erster natürlich nicht besser möglich ist. Weiter gibt der Typ auch Auskunft über die Effizienz, bei const hat die Tabelle einen Treffer - bei all muss ein fullscan gemacht werden.
## Logische Optimierung
Führen Sie folgende Query aus:
```sql
select s.Name, v.titel, p.Name from
(select * from moreStudenten where MatrNr > 55555) s join morehoeren h on (s.MatrNr = h.MatrNr)
join moreVorlesungen v on (h.VorlNr = v.VorlNr) join moreProfessoren p on (p.PersNr = v.gelesenVon) where s.Name = 'Studentin_12400';
```
#### Wie lange dauert die Abfrage?
Bei 4 Aufrufen zwischen 12s660ms-12s990ms
#### Wie sieht der Explain Plan für diese Anfrage aus?
```sql
Explain select s.Name, v.titel, p.Name from
(select * from moreStudenten where MatrNr > 55555) s join morehoeren h on (s.MatrNr = h.MatrNr)
join moreVorlesungen v on (h.VorlNr = v.VorlNr) join moreProfessoren p on (p.PersNr = v.gelesenVon) where s.Name = 'Studentin_12400';
```
| id | select\_type | table | partitions | type | possible\_keys | key | key\_len | ref | rows | filtered | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | SIMPLE | h | NULL | ALL | NULL | NULL | NULL | NULL | 10279308 | 100 | Using where |
| 1 | SIMPLE | v | NULL | eq\_ref | PRIMARY | PRIMARY | 4 | moreunidata2.h.VorlNr | 1 | 100 | Using where |
| 1 | SIMPLE | p | NULL | eq\_ref | PRIMARY | PRIMARY | 4 | moreunidata2.v.gelesenVon | 1 | 100 | NULL |
| 1 | SIMPLE | moreStudenten | NULL | eq\_ref | PRIMARY | PRIMARY | 4 | moreunidata2.h.MatrNr | 1 | 10 | Using where |
#### Wie sieht der Anfragebaum für diese Anfrage aus?
Das Problem ist, dass erst alle Tabellen vereinigt werden und erst am Schluss die Studentin gesucht wird.
#### Wie sieht der optimierte Abfragebaum aus?
Nach der Studentin soll bereits beim ersten join eingeschränkt werden.
#### Wie sieht das SQL der optimierten Query aus?
```sql
select s.Name, s.MatrNr, v.titel, p.Name from
(select MatrNr, Name from moreStudenten where MatrNr = 1012400) s join morehoeren h on (s.MatrNr = h.MatrNr)
join moreVorlesungen v on (h.VorlNr = v.VorlNr) join moreProfessoren p on (p.PersNr = v.gelesenVon);
```
#### Wie lange dauert das logisch optimierte Query?
Bei 4 Anfragen zwischen 3s151ms-3s261ms
#### Wie sieht der Explain Plan für die logisch optimierte Anfrage aus?
| id | select\_type | table | partitions | type | possible\_keys | key | key\_len | ref | rows | filtered | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | SIMPLE | moreStudenten | NULL | const | PRIMARY | PRIMARY | 4 | const | 1 | 100 | NULL |
| 1 | SIMPLE | h | NULL | ALL | NULL | NULL | NULL | NULL | 10279308 | 10 | Using where |
| 1 | SIMPLE | v | NULL | eq\_ref | PRIMARY | PRIMARY | 4 | moreunidata2.h.VorlNr | 1 | 100 | Using where |
| 1 | SIMPLE | p | NULL | eq\_ref | PRIMARY | PRIMARY | 4 | moreunidata2.v.gelesenVon | 1 | 100 | NULL |
## Erstellung von Indexen
#### Wie lange dauert die Erstellung des Indexes?
```sql
alter table moreHoeren add constraint primary key (MatrNr,
VorlNr);
```
Das Ausführen des Befehls dauert 10s601ms
#### Was bedeutet dies bezüglich Kosten/Nutzen Überlegungen?
Die Kosten sind realtiv hoch und dauert länger als obiges optimiertes Query. Der Index lohnt sich sofern die Daten mehr als einmal abgefragt werden. 
#### Führen Sie das obige Query nochmals aus, wie lange dasuert das Query jetzt?
```sql
select s.Name, v.titel, p.Name from
(select * from moreStudenten where MatrNr > 555555) s join morehoeren h on (s.MatrNr = h.MatrNr)
join moreVorlesungen v on (h.VorlNr = v.VorlNr)
join moreProfessoren p on (p.PersNr = v.gelesenVon) where s.Name = 'Studentin_12400';
```
Die Abfrage dauert noch zwischen 207 bis 243ms.
#### Wie sieht der Explain Plan aus? Woran sehen Sie die Optimierungen gegenüber vorher?
| id | select\_type | table | partitions | type | possible\_keys | key | key\_len | ref | rows | filtered | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | SIMPLE | moreStudenten | NULL | range | PRIMARY | PRIMARY | 4 | NULL | 498443 | 10 | Using where |
| 1 | SIMPLE | h | NULL | ref | PRIMARY | PRIMARY | 4 | moreunidata2.moreStudenten.MatrNr | 99 | 100 | Using index |
| 1 | SIMPLE | v | NULL | eq\_ref | PRIMARY | PRIMARY | 4 | moreunidata2.h.VorlNr | 1 | 100 | Using where |
| 1 | SIMPLE | p | NULL | eq\_ref | PRIMARY | PRIMARY | 4 | moreunidata2.v.gelesenVon | 1 | 100 | NULL |

