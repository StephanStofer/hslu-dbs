# SW02 – Übungen Datenmodellierung
## 1. Selbststudium
###### Welche Assoziationstypen gibt es?
Assoziationstypen (Kardinalitäten genannt) sagen aus, wie oft ein Element der jeweiligen Entitätsmenge in der Beziehung vorkommen kann. Insegesamt gibt es vier:
1. Konditionelle Assoziation	Keine bis eins	Typ c
2. Einfache Assoziation	Genau eins		Typ 1
3. Mehrfache-konditionelle Assoziation	Keins bis viele	Typ mc
4. Mehrfache Assoziation	Eins bis viele	Typ m
###### Wann ist eine Spezialisierung vollständig? Wann ist sie disjunkt?
Sofern sie eindeutig identifizierbar ist.
Disjunkt ist eine Spezialisierung wenn sich Entitätsmengen gegenseitig ausschliessen. Zum Beispiel kann ein Mitarbeiter nicht gleichzeiteig Führungskraft sein.
###### Wozu werden die Normalformen eingesetzt, und aus welchem Grund?
Normalformen helfen bei der Vermeidung von Redundanz. Redundanzen führen zu Anomalien.
###### Was ist eine Löschanomalie? Erklären Sie dies anhand eines konkreten Beispiels.
Eine Lösch-Anomalie (Delete-Anomalie) entsteht, wenn durch das Löschen eines Datensatzes mehr Informationen als erwünscht verloren gehen. Sie entsteht, wenn ein Datensatz mehrere unabhängige Informationen enthält. Durch das Löschen der einen Information wird dann auch die andere gelöscht, obwohl diese noch benötigt wird.
Als Beispiel dient Eine Tabelle die Module und Studierende enthält. Wird nun ein Modul gelöscht, werden auch Studierende entfernt. Dies führt zu inkonsistenten Daten.
###### Was ist eine funktionale Abhängigkeit?
Eine funktionale Abhängigkeit bildet die Grundlage für die Normalisierung von Relationsschemata. Funktional Abhängig bedeutet wenn Attribute zur eindeutigen Identifizierung von anderen Attributen abhängt. Zum Beispiel in einer Kundatendatenbank ist die Strasse und Ort funktional Abhängig vom Namen und Geburtsdatum des Kunden. Denn über den Namen sowie Geburtsdatum ist der Kunde eindeutig identifizierbar.
##### Was ist eine volle funktionale Abhängigkeit?
Die volle funktionale Abhängigkeit wird mit der 2NF erreicht. Eine vollständig funktionale Abhängigkeit liegt dann vor, wenn dass Nicht-Schlüsselattribut nicht nur von einem Teil der Attribute eines zusammengesetzten Schlüsselkandidaten funktional abhängig ist, sondern von allen Teilen eines Relationstyps. Die Tabellen werden so aufgeteilt, dass sie eigene Entitäten enthalten.
##### Was ist eine transitive Abhängigkeit?
Mit der 3NF wird die transitive Abhängigkeit erreicht. Eine transitive Abhängigkeit liegt dann vor, wenn Y von X funktional abhängig und Z von Y, so ist Z von X funktional abhängig. Diese Abhängigkeit ist transitiv.
##### Welchen Bezug haben diese Abhängigkeiten zu den Normalformen 1 – 3?
Siehe in den vorherigen drei Fragen.
##### Was ist der Unterschied zwischen einer Tabelle und einer Relation?
Eine Tabelle ist eine Entitätsmenge und eine Relation ist eine Beziehungsmenge, diese sind mittels Schlüssel refernziert.
##### Welches sind die zwei wichtigen Schlüsseleigenschaften?
Primär-/ Fremdschlüssel
##### Warum braucht es für einfach-komplexe und einfach-einfache Beziehungsmengen keine Bezeiehungstabelle?
Entitäten sind nachwievor eindeutig identifizierbar.
 
