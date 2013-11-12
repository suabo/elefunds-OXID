# elefunds-OXID

The elefunds OXID module.


## Installationsanleitung für Elefunts OXID Modul V.4.8.0

1. Kopieren Sie alle Dateien aus copy_this in ihr Shop root Verzeichnis.
2. Aktivieren Sie das Modul im Backend unter Erweiterungen > Module > Elefunds.
3. Elefunds API Zugang eintragen und Moduleinstellungen vornehmen.
4. Löschen Sie ihren Shop-Cache (`/tmp/`).

## Aktualisierung des Spendenstatus:

Wenn Sie das OXID Backend verwenden, werden die Spenden von der Einstellung im Modul 
abhängig abgeglichen, wenn Sie die Startseite des Backend, die Bestellübersicht und/oder
die Spendenübersicht aufrufen. Hierbei werden Spenden, deren Bestellung als bezahlt oder 
storniert markiert sind an Elefunds gemeldet. In diesem Fall muss kein Cronjob eingerichtet werden.

## Spendenstatus per Cronjob aktualisieren:

Damit der Spendenstatus von bezahlten Spenden auch an die Elefunds API gemeldet werden kann, 
wenn Sie das OXID Backend nicht verwenden, müssen Sie einen Cronjob einrichten.
Koieren Sie das Cronscript in ein Verzeichnis außerhalb von www.  
Zum Beispiel: `/root/cron/`  
Im Script selbst muss die Domain eingetragen und ein Zugang für das OXID Backend hinterlegt werden.

Um alle 5 Minuten einen abgleich durchzuführen, fügen Sie folgende Zeile zur Datei /etc/crontab hinzu: 

    */5 *   * * *   root  php5 /root/cron/lfndsdonationobserver.php
    
## Bekannte Probleme
### Elefunds Widget erscheint nicht:
bei ältern Shopversionen ist es notwendig eine neuere Version von JQuery zu laden.
Aktivieren Sie diese Einstellung im Modul, sollte das Widget nicht angezeigt werden.
