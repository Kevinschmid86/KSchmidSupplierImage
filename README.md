# KSchmidExtendListingProperties

### Kurzbeschreibung: 
Aktuell lassen sich Freitextfelder vom Typ ShopwareMedia innerhalb eines Listings beim Hersteller nicht ausgeben. Shopware liefert an das Frontend lediglich eine MediaId mit. 
Dieses Plugin sorgt dafür, dass die MediaId korrekt aufgelöst wird und der korrekte Media Pfad an das Frontend per Controller zurückgegen wird.
Zusätzlich wurde das Plugin dahingehend erweitert, dass das Herstellerbild nun auch auf der Artikeldetailseite zur Verfügung steht. 

### Installation: 

Plugin installieren und einmal sämtliche Caches löschen.

###Konfigurationsparameter

Es wird ein einfaches Textfeld innerhalb der Pluginkonfiguration angeboten. Dort muss der Spaltenname des Freitextfeldes vom Typ Shopware Media angegeben werden, welcher im Frontend im Artikellisting (Manufacturer) ausgelesen werden soll.
 
###Beispielaufruf über Smarty
    {if $kschmidManufacturerImage}
        <div class="hero--mediafile">
            {if isset($kschmidManufacturerImage.thumbnails[1].sourceSet)}
                <img class ="vendor--image" srcset="{$kschmidManufacturerImage.thumbnails[1].sourceSet}"
                     alt="{$kschmidManufacturerImage.description|escape}"
                     title="{$manufacturer->getName()|truncate:160}" />
            {else}
                <img class="vendor--image" src="{link file=$kschmidManufacturerImage.source}"
                     alt="{$kschmidManufacturerImage.description|escape}"
                     title="{$manufacturer->getName()|truncate:160}" />
            {/if}
        </div>
    {/if}