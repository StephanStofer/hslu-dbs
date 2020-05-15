# Graphdatenbanken
## Selbststudium
### Was ist ein Eigenschaftsgraph?
Ein Eigenschaftsgraph (engl. property graph) besteht aus Knoten (Konzepte, Objekte) und gerichteten Kanten (Beziehungen), die Knoten verbinden. Sowohl die Knoten wie die Kanten tragen einen Namen (engl. label) und können Eigenschaften (engl. properties) aufweisen. Die Eigenschaften werden als Attribut-Wert-Paare der Form (attribute: value) mit Attributnamen und zugehörigen Werten charakterisiert.
### Wie könnten Eigenschaftsgraphen mathematisch definiert werden?
Mit der Graphentheorie.
### Welche Gemeinsamkeiten und Unterschiede bestehen zwischen relationalen und graphorientierten Datenbanken?
Entitäten entsprechen Knoten und die Beziehungen entsprechen Kanten. 
### Wie werden Entitätsmengen im Graphschema umgesetzt?
Jede Entitätsmenge wird als eigenständiger Knoten dargestellt. Alle Merkmale der Entitätsmenge wird als Eingenschaft des Knoten geführt.
### Wie werden Beziehungsmengen im Graphschema umgesetzt?
Jede Beziehungsmenge kann als ungerichtete Kante in der Graphdatenbank definiert werden. Die Eigenschaften der Beziehungsmenge werden den Kanten zugeordnet (attributierte Kanten).
### Wie werden Attribute im Graphschema umgesetzt?
Die Kanten tragen Labels
## Cypher Tutorial
[Cypher Tutorial](https://sql-nosql.org/de/cypher-tutorial)
(https://sql-nosql.org/de/cypher-tutorial)
## Neo4J Workbench
### Basic Queries

#### Basic Queries - Exercise 1:
Question: Find the movie A Beautiful Mind
```cypher
MATCH (m:Movie) WHERE lower(m.movie_name)="a beautiful mind" RETURN m
```
#### Basic Queries - Exercise 2:
Question: Find the movie a clockwork orange (Hint: use the lower function)
```cypher
MATCH (m:Movie) WHERE lower(m.movie_name)="a clockwork orange" RETURN m
```
#### Basic Queries - Exercise 3:
Question: Find all actors order by actor_name What is the problem? To solve it, continue to the next exercise
```cypher
MATCH (a:Actor) RETURN a ORDER BY (a:actor_name)
```
```console
ERROR: Resultset too large (over 1000 rows)
```
#### Basic Queries - Exercise 4:
Question: Find 50 actors order by actor_name. (Hint: Use this time limit)
```cypher
MATCH (a:Actor)  RETURN a ORDER BY (a:actor_name) limit 50
```
#### Basic Queries - Exercise 5:
Question: List all categories by their name (category_name) orderd by their name in reverse order(Hint: Switch to table view)
```cypher
MATCH (n:Category)
RETURN n.category_name
ORDER BY n.category_name DESC
```
#### Basic Queries - Exercise 6:
Question: List all Movies who have an IMDB Rating (movie_imdbRating) below 5 and Metascore is bigger than 55 (movie_metascore)
```cypher
MATCH (n:Movie)
WHERE (n.movie_imdbRating < '5')AND( n.movie_metascore > 55)
RETURN n
```
### Advanced Queries
#### Advanced Queries - Exercise 1:
Question: List all features of the movie Shrek
```cypher
MATCH (n:Movie{movie_name:"Shrek"})-[:linked_to]->(Feature)
RETURN Feature.feature_name
```
#### Advanced Queries - Exercise 2:
Question: Show all movies who are assoziated to the keyword "swordsman"
```cypher
MATCH (n:Movie)-[:has]->(Keyword{keyword_name:"swordsman"})
RETURN n.movie_name
```
````console
13 Assassins
Kingdom of Heaven
````
#### Advanced Queries - Exercise 3:
Question 1: How many users have watched the movie Titanic
````cypher
MATCH (n:Movie{movie_name:"Titanic"})<-[:watched]-(User)
RETURN count(n)
````
````console
320
````
Question 2: Find all movies who has been watched by more then 400 users (Hint: Use with)
```cypher
MATCH (n:Movie)-[:watched]-(User)
WITH n, count(User) AS watchers
WHERE watchers > 400
RETURN (n.movie_name)
```
Advanced Queries - Exercise 4:
Question 1: List all Movies who are related trough user like with the movie Agora.
```cypher
MATCH (user:User) --> (movie:Movie) 
WHERE movie.movie_name = "Agora"
RETURN (user), (movie)
```
Question 2: Show all related to the related.