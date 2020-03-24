# SW01 – Übungen SQL Grundlagen
## 1. Selbststudium
#### Welche Benutzergruppen gibt es und wie interagieren sie mit der Datenbank?
Alle verwenden die gleiche Datenbanksprache. Somit können sie auch Erfahrungen und Wissen untereinander austauschen.
###### Datanbankadmin
Verwalttet mit einer Datenbanksprache die Datenbeschreibungen für Tabellen und Merkmale. Unterstützt werden sie von einem Data-Dictionary-System. Mit Hilfe der Datenarchitekten sorgen sie dafür, dass die Beschreibungsdataten einheitlich und konstitent verwaltet und nachgeführt werden. Kontrollieren Datenformate und legen Berechtigungen fest, wie Daten genutzt und verändert werden dürfen.
###### Datanbankspezialist
Definieren installieren und überwachen Datenbanken mit Hilfe von Systemtabellen. Mit Hilfe des Systemkatalogs, welcher zur Betriebszeit alle notwendigen Datenbankbeschreibungen und statistischen Angaben umfasst, können die Datenbankspezialisten sich ein aktuelles Bild über sämtliche Datenbanken machen. Dazu nutzen sie vorgegebene Abfragen, welche sich nicht um Benutzerdaten kümmern. Diese sollten aus Datenschutzgründen nur in Ausnahmesituationen zugänglich sein.
###### Abwendungsprogrammier/in
Verwenden die Datenbanksprache um neben Auswertungen auch Änderungen auf den Datenbanken vornehmen zu können. Sie benötigen ein Cursorkonzept um den Datenbankzugriff in ihre softwareentwicklung zu integrireren.
###### Datenanalysten
Verwenden Datenbanksprachen für tägliche Auswertungen von fachlichen Informationen. Diese stellen sie Fachabteilungen zur Verfügung.
#### Was ist der Unterscheid zwischen mengenorientierten und relationalen Operatoren?
###### mengenorientierte Operatoren
Definieren in der relationalen Algebra die Operationen auf einer oder zwei Tabellen mit gleichen Attributen wirken. Diese sind;
1. Vereinigung (Union)
2. Durchschnitt (intersection)
3. Differenz (difference)
4. kartesische Produkt (cartesian prodcut)
###### relationale Operatoren
Die Relationen müssen hier nicht vereinigungsverträglich sein. Dies bedeutet, dass man mit diesen Operationen Daten selektiert oder projeziiert. Mit Hilfes des Verbundsoperator (join) können zwei Relationen über ein gemeinsames Merkmal kombiniert werden.
#### Was ist der Zusammenhang von mengenorientierten Abfragesprachen und der Relationenalgebra?Alle Operationen lassen sich auf fünf Grundoperatoren der Relationenalgebra zurückführen (Vereinigung, Differenz, kartesisches Produkt, Projektions- und Selektionsoperatoren). Insebesondere ist die Relationenalgebra bei Optimierungen von Nutzen.
#### Wie wird die Selektion in SQL umgesetzt?
Mit Hilfe der WHERE-Klausel
#### Wie wird die Projektion in SQL umgesetzt?
Mit der SELECT-Klausel
#### Wie wird der Join in SQL umgesetzt?
Es gibt mehrere Möglichkeiten: Eine Variante ist die Tabellen Kommagetrennt anzugeben SELECT table1, table2
#### Wie zeigt sich die Eigenschaft von SQL, dass sie deskriptiv ist?
Die Ausdrücke beschreiben das gewünschte Resultat und nicht etwa die dazu erforderlichen Rechenschritte.
#### Was bedeutet die Aussage, dass SQL relational vollständig ist?
Die Aussage bedeutet, dass die fünf grundlegenden Operationen der Relationenalgebra von SQL unterstützt werden.
## 2. Forschungsliteratur
#### Was war die Grundidee von SEQUEL?
Datenmanipulation oder Abfrage von Daten in einer relationalen Datenbank mittels Keywords ermöglichen welche von Programmieren sowie von unregelmässigen Benutzern verwendet werden kann.
#### Welche zwei Gründe sprachen für die Einführung von deklarativen Sprachen?
1. Programmierung war sehr aufwändig und damit teuer. Eine deklarative Sprache kann einfacher und schneller gelernt werden.
2. Die Nutzung von Computern soll nicht nur Spezialisten vorenthalten sein. Der Erfolg ist abhängig von "Normalbenutzern"
#### Was ist der grosse Unterscheid zwischen SQUARE und SEQUEL?
SEQUEL nutzt ein English-Keyword Format, SQUARE hingegen präzise mathematische Notationen
#### Finden Sie einige Unterschiede zwischen dem ursprünglichen SEQUEL und dem heutigen SQL?
Integer values in '' -> s.255
Union and Intersection mit keyword and/or möglich -> s.257
## 3. SQL Workbench
#### 1.1
`SELECT * FROM movies`
#### 1.2
`SELECT username from user`
#### 1.3
22
`select count(*) from category`
#### 1.4
7292
`select count(distinct(lastname)) from crew`
#### 1.5
yes
`select title from movies where title = 'a beautiful mind'`
#### 1.6
`select * from award order by name desc`
#### 1.7
`select title from movies where budget > 280000000`
#### 1.8
yes
`select username from user where username like '%norris%'`
#### 1.9
`select name from keywords where name like 'can%'`
#### 1.10
`select username, location from user where location like 'Ba__'`
#### 1.11
what should be problematic?
`select username, age from user where watched > 800 and age < 12`
#### 1.12
i dont get it..
#### 1.13
???
#### 1.14
1691
`select title, imdbRating from movies where imdbRating = 7.0 or imdbRating = 8.0`
#### 1.15
234
`select title, imdbRating, metascore from movies where metascore > 80 or imdbRating > 8.0 and year > 2012`
#### 2.1
`Select title, code from movies m, country c, playsInCountry pic where pic.m_id = m.id and c.id = pic.c_id`
#### 2.2
very very slow...
`Select m.title, c.firstname, c.lastname, cf.name from movies m, crew c, crewFunction cf, isPartOf ipo where ipo.m_id = m.id and ipo.p_id = c.id and c.f_id = cf.id`

tried: ?Select m.title, c.firstname, c.lastname, cf.name from isPartOf ipo 
left join movies m on ipo.m_id = m.id
left join crew c on ipo.p_id = c.id`

