# SW11 – Integritätssicherung
## Selbststudium
Unter dem Begriff Integrität oder Konsistenz (engl. integrity, consistency) versteht man die Widerspruchsfreiheit von Datenbeständen. Eine Datenbank ist integer oder konsistent, wenn die gespeicherten Daten fehlerfrei erfasst sind und den gewünschten Informationsgehalt korrekt wiedergeben. Die Datenintegrität ist dagegen verletzt, wenn Mehrdeutigkeiten oder widersprüchliche Sachverhalte zu Tage treten.
#### Welche 3 Arten von strukturellen Integritätsbedingungen gibt es?
##### Eindeutigkeitsbedingung
Jede Tabelle besitzt einen Identifikationsschlüssel (Primary Key), der jeder Tupel in der Tabelle auf eindeutige Art bestimmt. Das Prüfen auf Eindeutigkeit von PK's selbst wird vom DBS vorgenommen.
##### Wertebereichsbedingung
Die Merkmale einer Tabelle können nur Datenwerte aus einem vordefinierten Wertebereich annehmen. Das DBS kann nur teilweise die Bedingungen gewährleisten. Als Beispiel kann das System die Bedeutung bzw. Wahrheit einer Adresse nur bedingt prüfen oder die Länge eine VARCHAR(25) sagt auch nichts über deren Inhalt aus. Eine Alternative bieten Aufzählungstypen. Dabei werden alle Datenwerte, die das Merkmal annehmen kann, in einer Liste angegeben (zB. Jahrgang, Berufe, usw.)
##### Referenzielle Integritätsbedingung
Jeder Wert eines Fremdschlüssels muss effektiv als Schlüsselwert in der referenzierten Tabelle existieren. Dies bedeutet, dass Referenzen nur eingefügt werden können (also der FK), wenn dieser auch existiert. Dann gilt die referenzielle Integritätsbedingung. Diese Bedingung hat natürlich Einfluss auf alle Datenbankoperationen (einfügen, modifzieren, löschen). Wird ein Tupel gelöscht, welches eine Referenz als FK enthält, sind mehrere Varianten von Systemraktionen möglich:
* Restriktive Löschung (restricted deletion); eine Löschoperation wird nicht ausgeführt, sofern andere Tupel aus der gleichen oder auch aus anderen Tabellen Referenzen auf das zu löschende Tupel zeigen.
* Fortgesetzte Löschregel (cascaded deletion); ein löschen bewirkt, dass sämtliche abhängigen Tupel auch entfernt werden. 
* Nullwerte (set null); die Werte wo Fremdschlüssel eingetragen sind werden auf «null» gesetzt.
#### Wie lautet die Definition für den Begriff «Referenzielle Integrität»?
aus Wikipedia:
> „Die referentielle Integrität (auch Beziehungsintegrität) besagt, dass Attributwerte eines Fremdschlüssels auch als Attributwert des Primärschlüssels vorhanden sein müssen.“
>„Über die referentielle Integrität werden in einem DBMS die Beziehungen zwischen Datenobjekten kontrolliert.
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
