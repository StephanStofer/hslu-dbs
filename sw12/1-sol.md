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
Ist eine Erweiterung des Schlüssel-Wert-Konzept mit etwas mehr Struktur. Für die Optimierung des Lesezugriffs werden die Daten nicht zeilenweise, sonder spaltenweise gespeichert. Oft werden nur einzelne Spalten abgefragt und selten die ganze Zeile. Die Spalten werden in Gruppen von Spalten zusammengeführt, welche häufig zusammen gelesen werden. Die Vorteile von Spaltenfamilien-Datenbanken sind hohe Skalierbarkeit und Verfügbarkeit durch massibe Verteilung (wie K/V-Stores). Ausserdem bieten sie eine Struktur durch ein Schmea mit Zugriffskontrolle und Lokalisation von verteilten Daten auf Ebene Spaltenfamilie. Trotzdem lassen sie innerhalb der Spaltenfamilie genügend Freiraum mit der möglichen Verwendeung von beliebigen Spaltenschlüsseln.
##### BigTable
Ist eine von Google vorgestelltes Datenbankmodell für die verteilte Speicherung von strukturierten Daten. Im BigTable-Modell ist eine Tabelle eine dünnbesetzte, verteilte, multidimensionale, sortierte Map mit folgenden Eigenschaften.
* Es handelt sich bei der Datenstruktur um eine Abbildung, welche Elemente aus einer Definitionsmenge Elementen einer Zielmenge zuordnet.
* Die Abbildung ist sortiert, d. h. es existiert eine Ordnungsrelation für die Schlüssel, welche die Zielelemente adressieren.
* Die Adressierung ist mehrdimensional, d. h. die Funktion hat mehr als einen Parameter.
* Die Daten werden durch die Abbildung verteilt, d. h. sie können auf vielen verschiede-
nen Rechnern an räumlich unterschiedlichen Orten gespeichert sein.
* Die Abbildung ist dünnbesiedelt, muss also nicht für jeden möglichen Schlüssel einen
Eintrag aufweisen.
###### Rudimentäres Schema
Spaltenfamilien sind die einzigen festen Schemaregeln der Tabelle und müssel explizit durch Änderung der Schemas der Tabelle erstellt werden. Innerhalb der Spaltenfamilien können aber beliebige Spaltenschlüssel für die Speicherung von Daten verwendet werden.
#### Dokument-Datenbanken
Dieses Modell vereinigt die Schemafreiheit von K/V-Speichern mit Möglichkeit zur Strukturiereung der gespeicherten Daten. Effektiv werden nicht Dateien (Office, Video, Musik, usw.) gespeichert sondern strukturierte Daten in Datensätze, welche Dokumente genannt werden. Sie wurden für den Einsatz für Webdienste entwickelt und sind einfach in Webtechnologien wie JavaScript und HTTP integrierbar. Weiter sind sie einfach horizontal skalierbar (sharding). Ein Nachteil aus der Schemafreiheit kann der Verzicht auf referenzielle Integrität und Normalisierung sein. Aber dadurch ist sie extrem flexibel in der Speicherung unterschiedlichster Daten (Variety).
Ein Dokument wird als strukturierte Datei (zB. JSON) gespeichert. Diese enthält jeweils Attribut-Wert-Paaren dar. Diese können rekursiv wiederum Listen von Attribut-Wert-Paare enthalten. Die Dokumente haben untereinander keine Beziehung, sondern enthalten eine in sich abgeschlossene Sammlung von Daten.
##### Eigenschaften
• Sie ist eine Schlüssel-Wert Datenbank.
• Die gespeicherten Datenobjekte als Werte zu den Schlüsseln werden Dokumente
genannt; die Schlüssel dienen der Identifikation.
• Die Dokumente enthalten Datenstrukturen in der Form von rekursiv verschachtelten
Attribut-Wert-Paaren ohne referenzielle Integrität.
• Diese Datenstrukturen sind schemafrei, d. h. in jedem Dokument können beliebige
Attribute verwendet werden, ohne diese zuerst in einem Schema zu definieren.
#### XML-Datenbanken
Eine native XML-Datenbank hat folgende Eigenschaften
* Die Daten werden in Dokumenten gespeichert, ist also eine Dokument-Datenbank.
* Die strukturierten Daten in den Dokumenten sind kompatibel mit dem XML-Standard.
* XML-Technologien wie XPath, XQuery und XSL/T können zur Abfrage und Mani-
pulation der Daten angewendet werden.
Native XML-Datenbanken speichern Daten streng hierarchisch in einer Baumstruktur. Sie sind dann besonders gut geeignet, wenn hierarchische Daten in standardisiertem Format gespeichert werden sollen, beispielsweise bei Web-Services in der serviceorien- tierten Architektur (SoA). Ein großer Vorteil ist der vereinfachte Datenimport in die Datenbank, der bei einigen Datenbanksystemen durch simples Drag and Drop von XML-Dateien erreicht werden kann. 
#### Graphdatenbanken
Haben als strukturierendes Schema dasjenige des Eigenschaftsgraphen. Daten werden in Form von Knoten und Kanten gespeichert, welche zu einem Knoten- bzw. Kantentyp gehört und Daten in Form von Attribut-Wert-Paare enthalten. Es handelt sich um ein implizites Schema. Datenobjekte können zu einem bisher nicht existierenden Knoten- oder Kantentyp direkt eingefügt werden ohne den Typ vorher zu definieren. Die Beziehungen zwischen Datenobjekten sind explizit als Kanten vorhanden. Die Referenzielle Integrität wird vom DBS sichergestellt. Graphdatenbanken kommen überall dort zum Einsatz, wo Daten in Netzwerken organisiert sind. Der einzelne Datensatz ist weniger wichtig, sondern die Verknüpfung der Datensätze untereinander (zb. Social Media, Infrastrukturnetzen, Internet-Routing, usw.). Vorteil ist die Eigenschaft der indexfreien Nachbarschaft (findet direkten Nachbarn ohne sämtliche Kanten zu berücksichten). Der Aufwand für die Abfrage von Beziehungen zu einem Knoten ist konstant, unabhänig vom Datenvolumen. Für den schnellen Zugriff auf Knoten und Kanten bereitzustellen werden Indexe eingesetzt, wobei dieser als balancierte B-Bäume aufgebaut werden. Heutige Graphdatenbanken unterstützen das Sharding noch nicht und kann höchstens mit domänenspezifischen Wissen verteilt werden.
##### Eigenschaften
• Die Daten und/oder das Schema werden als Graphen (siehe Abschn. 2.4) oder graphähnlichen Strukturen abgebildet, welche das Konzept von Graphen generalisieren (z. B. Hypergraphen).
• Datenmanipulationen werden als Graph-Transformationen ausgedrückt, oder als Operationen, welche direkt typische Eigenschaften von Graphen ansprechen (z. B. Pfade, Nachbarschaften, Subgraphen, Zusammenhänge, etc.).
• Die Datenbank unterstützt die Prüfung von Integrita€tsbedingungen, welche die Datenkonsistenz sicherstellt. Die Definition von Konsistenz bezieht sich direkt auf Graph- Strukturen (z. B. Knoten- und Kantentypen, Attribut-Wertebereiche und referenzielle Integrität der Kanten).

