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
Eine Tabelle ist in erster Normalform, falls die Wertebereiche der Merkmale atomar sind. Die erste Normalform verlangt, dass jedes Merkmal Werte aus einem unstrukturierten Wertebereich bezieht. Somit du ̈rfen keine Mengen, Aufza ̈hlungen oder Wiederholungs- gruppen in den einzelnen Merkmalen vorkommen. 
