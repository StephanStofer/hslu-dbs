# Big Data & NoSQL Datenbanken
## Review Questions
### Aus welchen Grüden entstand die NoSQL-Bewegung?
Mit dem Siegeszug des WWW entstanden auch weitere BEdürfnisse in Bezug auf Datenhaltung im Petabyte-Bereich. Die bestehenden SQL-Lösungen sind aber weit mehr als reine Datenspeicher und bieten einen hohen Grad an Verarbeitungslogik. Ideal für Konsistenzsicherung, welche aber mit viel Aufwand und Rechenleistung verbunden ist. Dadurch stossen diese bei umfangreichen Datenmengen schneller an ihre Grenzen. Auch hinsichtlich Flexibilität wird man durch die Mächtigkeit des Datenbankverwaltungssystems ein wenig eingeschränkt. Auch aus diesem Grund wurde in der Open Source- und Web-Development-Community schon bald die Entwicklung massiv verteilter DBS vorangetrieben.
### Was ist der Unterscheid zwischen SQL und NoSQL?
* Datenbankmodell ist nicht relational
* NoSQL ist auf verteilte und horizontale Skalierbarkeit ausgerichtet
* NoSQL hat schwache oder keine Schema-Restriktionen
* Einfache Datenreplikation
* Einfacher Zugriff über eine API
* NoSQL hat anderes Konsistenzmodell
### Welche Vorteile hat SQL gegenüber NoSQL?
Unter anderem Konsistenz und Sicherheit der Daten. Ideal für Banken und Versicherungen.
* Mächtige deklarative Sprachkonstrukte
* Schemata, Metadaten
* Konsistenzgewährung
* Referenzielle Integrität, Trigger
* Recovery, Logging
* Mehrbenutzerbetrieb, Synchronisierung
* User, Rollen, Security
* Indexierung
### Welche Vorteile hat NoSQL gegenüebr SQL?
Performant und kann immense Datenmengen effizient verarbeiten. Ideal für Web-/SocialMedia Anwendungen.
### Was heisst Schemafreiheit?
Es muss keine Tabelle mit Spalten und Datentypen spezifiziert werden. Daten können unter einem beliebigen Schlüssel abgelegt werden.
### In welchen Szenarien setzt man optimal auf welche der beiden Varianten?
SQL in Szenarien wo Konsistenz und Sicherheit wichtiger sind, als Performanz und Datenwachstum.
### Welche NoSQL-System-Typen gibt es? Welche spezifischen Vorteile haben die einzelnen Arten jeweils?
#### Schlüssel-Wert-Datenbanken
Identifizierendes Datenobjekt ist der Schlüssel. Zu jedem Schlüssel gibt es genau ein assoziiertes deskriptives Datenobjekt, welches den Wert des Schlüssels darstellt. Mit der Angabe des Schlüssel kann der zugehörige Wert aus der Datenbank abgefragt werden.
Bei grosser Skalierung werden die Key/Values Stores in mehrere Cluster (Shards) aufgeteilt werden. Ein Shard nimmt dabei nur ein Teilraum der Schlüssel bei sich auf. So kann die Datenbank auf viele Rechner verteilt werden. Das Verteilen basiert auf einem Hash und Modulo Operation um auf die Hash Slots verteilen zu können.
Die Daten können unter beliebigen Schlüssel abgelegt werden, sind also quasi schemafrei und somit flexibel in der Art der zu speicherenden Daten.
#### Spaltenfamilien-Datenbanken
Ist eine Erweiterung des Schlüssel-Wert-Konzept mit etwas mehr Struktur. Für die Optimierung des Lesezugriffs werden die Daten nicht zeilenweise, sonder spaltenweise gespeichert. Oft werden nur einzelne Spalten abgefragt und selten die ganze Zeile. Die Spalten werden in Gruppen von Spalten zusammengeführt, welche häufig zusammen gelesen werden.
##### BigTable
Ist eine von Google vorgestelltes Datenbankmodell für die verteilte Speicherung von strukturierten Daten.
#### Dokument-Datenbanken

#### XML-Datenbanken

#### Graphdatenbanken
