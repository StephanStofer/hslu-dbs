# SW08 – Datenbankprogrammierung
## 1. Lehrmittel
#### Was ist ein Cursor? Definieren Sie das Konzept in Ihren eigenen Worten.
Ein Cursor ist ein Zeiger mit welchen man zeilenweise Tupel verarbeiten kann. Basis des Cursors ist eine Select Abfrage welche alle konformen SQL konstrukte unterstützt. Die Verarbeitung finet typisch in einer While-Schlaufe statt. Der Cursor muss explizit geöffnet/geschlossen werden. Ein nächster Datensatz muss mit Fetch aktiviert werden. Die Daten selber werden in Variablen gespeichert.
#### Aus welchem Grund (warum) und zu welchem Zweck (wozu) braucht man Cursors?
Konventionelle Programme können keine ganze Tabellen auf einen Schlag verarbeiten. Damit können zeilenweise Daten verwendet/manipuliert werden.
#### Wozu werden DAtenbanksprachen in andere Sprachen eingebettet?
Um eine einheitliche Schnittstelle zu realisieren und iterativ auf Datenelemente zugreifen zu können.
#### Was ist der Unterschied zwischen objektorientierten und objektrelationalen Datenbanken?
Objektorientierte DBs können über Fremdschlüssel ein Objekt vortäuschen. In der Objektrelationealen DB können zusätzlich Objettypen definieren oder generische Operatoren enthalten. Ausserdem untertützt es die Vererbung von Objekteigenschaften.
#### Was ist ein Surrogat? und was hat es mit Objektorientierung zu tun?
Ein Surrogat ist ein Fremdschlüssel womit sich jeder Record einer anderen Tabelle eindeutig identifizieren lässt. Damit lassen sich "klassen" bilden und trotzdem die Normalenform einhalten.
#### Was ist das NF^2 Modell? Was ist der Zusammenhang von NF^2 mit der Objektorientierung?
NF^2 = Non First Normal Form. Diese erlaubt geschachtelte Tabellen. Das bilden von Objekten die wiederum Objekte enthalten?
#### Was ist objekt-relationales Mapping, und was sind die Vorteile?
Das automatische Mapping zwischen Objektorientierter SW-Entwicklung und relationaler Datenspeicherung. Es bruaucht keine aufwendiges Führen von Mappingalgorithmen.

