#SW06 - SQL Sprachkonzepte
## Daten manipulieren
#### Erstellen Sie eine Tabelle Hilfsassistenten mit gleichen Attributen wie Tabelle Assistenten
`create table hilfsassistenten as select * from assistenten where 1=0`
#### Fügen Sie Hilfsassistenten ein
`insert into hilfsassistenten values (3006,'Newton','Naturphilosophie',2136),(4001,'Chomsky','Sprachphilosophie',2137);`
#### Ändern des Fachgebietes von Newton
```SQL
update hilfsassistenten set fachgebiet = 'idealistische Mataphysik' 
    where name = 'Newton';
```
#### Chomsky löschen
```SQL
delete FROM hilfsassistenten where persnr = 4001;
```
## Daten aggregieren
#### Wieviele Profs mit Rang C3 gibt es?
7
```SQL
select count(rang) from professoren;
```
#### Anzahl Semester
###### min
2
```SQL
select min(semester) from studenten;
```
###### avg
7.625
```SQL
select avg(semester) from studenten;
```
###### max
18
```SQL
select max(semester) from studenten;
```
#### Semesterwochenstunden gruppiert nach Prof
```SQL
select p.name, sum(v.sws) from professoren p
    left join vorlesungen v on v.gelesenvon = p.persnr
    group by p.name;
```
## Mengenvergleiche (in)
#### Prof finden, der noch keine Prüfung abgenommen hat (mit Inline View)
```SQL
select p.name from professoren p where p.persnr not in (select pr.persnr from pruefen pr);
```
## Inner Join
#### Welche Vorlesungen hört Carnap bei welchen Profs
```SQL
select s.name as Student, v.titel as Vorlesung, p.name as Professor
    from hoeren h, studenten s, vorlesungen v, professoren p
    where h.matrnr = s.matrnr and h.vorlnr = v.vorlnr and v.gelesenvon = p.persnr and s.name = 'Carnap';
```
## Left outer join
#### Liste aller Proifs mit Assistent
```SQL
select * from professoren p
    left join assistenten a on p.persnr = a.boss;
```
## Full outer join
#### List aller Studis und Vorlesungen die sie hören. Studi oder Vorlesung trotzdem ausgeben auch wenn nicht besucht
```SQL
select s.matrnr, s.name, v.vorlnr, v.titel from hoeren h
    full outer join studenten s on s.matrnr = h.matrnr
    full outer join vorlesungen v on h.vorlnr = v.vorlnr;
```
## Right outer join
Vorgabe ist dieser Query
```SQL
select v.Titel, s.name
    from vorlesungen v
    left outer join hoeren h on h.VorlNr = v.VorlNr right outer join Studenten s on s.MatrNr = h.MatrNr;
```
#### Was geschieht wenn right outer mit left outer join ersetzt wird?
Mit dem left outer werden alle Vorlesungen ausgegeben, auch wenn sie nicht von Studenten besucht werden.
Was geschieht, wenn in der letzten Zeile full outer join verwendet wird?
alle Studenten und Vorlesungen werden ausgegeben, ob die Vorlesung besucht bzw. ob ein Student eine Vorlesung besucht.
## Metadaten
#### UseCase von Metadaten und wie kann Data Dictionary durchsucht werden?
Ein UseCase ist zum Beispiel das finden einer Spalte wovon man lediglich den Namen weiss. Ein weiterer könnte das auffinden von Spalten mit bestimmen Datenttypen sein.\
Das Data Dictionary kann wie eine normale Datenabfrage mittels Query durchsucht werden. Dies funktioniert, weil sämtliche Metadaten auch in Tabellen verwaltet werden.
#### Welche Tabellen enthält die Spalte "Fachgebiet"
Hilfs-/Assistenten
```SQL
select columns.table_name from information_schema.columns
    where column_name like '%fachgebiet%';
```
#### Welche Spalten haben den Datentyp Integer?
```SQL
select column_name from information_schema.columns 
    where data_type = 'integer';
```
#### Welche Tabellen enthält das Information Schema?
alle ausser sich selber
```sql
Select * from information_schema.tables;
```
## Nullwerte
Gegeben folgendes Query:
```SQL
select 1, count(*) from studenten
    where semester < 13 or semester >= 13
union
    select 2, count(*) from studenten;
```
#### Was fällt beim ausführen auf? Wieso ist Resultat inkonsistent?
Beim 1. Query wird der Null-Wert in den Semestern nicht mitgezählt. Beim Vergleich zählt <null> weder zu < 13 noch zu >=13. Deshalb "fehlt" ein Stundent.
#### Wie muss Query definiert werden, damit auch bei Nullwerten konsistentes Resultat ausgegeben wird?
Mit den Vergleichskeyword is null oder is not null arbeiten:
```SQL
select 1, count(*) from studenten
    where semester < 13 or semester >= 13 or semester is null
union
    select 2, count(*) from studenten;
```
## Existenz
#### Was ist der Unterschied zwischen den Mengenvergleichen IN und EXISTS? Wann kann man etwas nur mit dem Exists-Operator abfragen?
Mit IN erhält man eine Spalte mit möglichen Resultaten. Diese Resultate werden dann von der left-hand-side jeweils durchsucht und verglichen. EXISTS liefert hingegen Zeilen. Deren Inhalt eigentlich keine Relevanz beizumessen ist. Sofern Zeilen existieren gibt EXISTS true zurück, wenn nicht false.\
```SQL
select pr.vorlnr from pruefen pr 
    where exists(select s.matrnr, p.persnr, p.rang 
        from studenten s, professoren p 
        where s.semester >= 10 and p.rang = 'C4');
```
## Fallunterscheidung
```SQL
select matrnr, (case when note >= 5.75 then 'Sehr gut'
    when note >= 4.75 then 'Gut'
    when note >= 3.75 then 'Genügend'
    else 'ungenügend'
    end)
from pruefen;
```
#### Warum muss nur Obergrenze geprüft werden?
Der jeweils erste Case welcher auf true auswertet wird ausgeführt.
## Rekursion
Gegeben folgendes Query:
```SQL
with recursive
vorlesungsnachfolger as (
    select vg.titel as von, nf.titel as nach, 1 as länge from voraussetzen vr
        join vorlesungen vg on vg.vorlnr = vr.vorgänger
        join vorlesungen nf on nf.vorlnr = vr.nachfolger
        ),
    pfad(von,nach,länge,folge) as (
    select v0.von, v0.nach, 1, v0.von || ','|| v0.nach
    from vorlesungsnachfolger v0
    union all
    select p.von, vn.nach, p.länge+1,
    p.folge ||','|| vn.nach from vorlesungsnachfolger vn join pfad p on p.nach = vn.von
        )
select * from pfad
where nach like '%thik';
```
#### Was macht das Query genau? Wo befindet sich der Rekursionsschritt? Erklären Sie die Funktionsweise dieser Query.
Das Query gibt die Wege aus, wie Module nacheinander absolviert werden können. Der Rekursionsschritt befindet sich beim `join pfad` im ```SQL
select` nach dem `union all`
## Windowing
#### Query schreiben wo pro Professor Anzahl Wochenstunden zusammenrechnet und den Rang ausgibt. Es sind Windowing-Functions zu verwenden:
```SQL
select p.name, sum(v.sws) as swsh, dense_rank() over(order by sum(v.sws) desc) as Rang from professoren p
inner join vorlesungen v on v.gelesenvon = p.persnr
group by p.name;
```

