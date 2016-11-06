# KSchmidExtendListingProperties

### Kurzbeschreibung: 
Aktuell lassen sich Freitextfelder vom Typ ShopwareMedia innerhalb eines Listings beim Hersteller nicht ausgeben. Shopware liefert an das Frontend lediglich eine MediaId mit. 
Dieses Plugin sorgt dafür, dass die MediaId korrekt aufgelöst wird und der korrekte Media Pfad an das Frontend per Controller zurückgegen wird. 

### Installation: 

Plugin installieren und einmal sämtliche Caches löschen.

###Konfigurationsparameter

Es wird ein einfaches Textfeld innerhalb der Pluginkonfiguration angeboten. Dort muss der Spaltenname des Freitextfeldes vom Typ Shopware Media angegeben werden, welcher im Frontend im Artikellisting (Manufacturer) ausgelesen werden soll. 