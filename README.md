# elefunds-OXID

The elefunds OXID module.


## Installationsanleitung für elefunds OXID Modul V.4.7.0 - 4.8.x

1. Kopieren Sie alle Dateien aus copy_this in ihr Shop root Verzeichnis.
2. Aktivieren Sie das Modul im Backend unter Erweiterungen > Module > Elefunds.
3. Moduleinstellungen vornehmen und elefunds API Zugang eintragen
4. Löschen Sie ihren Shop-Cache (`/tmp/`).

## Aktualisierung des Spendenstatus:

Spenden werden von der Einstellung im Modul abhängig automatisch abgeglichen, wenn Sie:
- die Startseite des Backend aufrufen `false`
- die Bestellübersicht aufrufen `true`
- die Spendenübersicht aufrufen `false`
- neue Spenden erhalten `true`

`defaults`

Hierbei werden Spenden, deren Bestellung als bezahlt oder storniert markiert 
sind an elefunds gemeldet. In diesem Fall muss kein Cronjob eingerichtet werden.
Sollten Sie aus bestimmten Gründen keine der Optionen wählen, so müssen Sie
einen Cronjob einrichten.

## Spendenstatus per Cronjob aktualisieren:

Damit der Spendenstatus von bezahlten Spenden auch an die elefunds API gemeldet werden kann, 
wenn Sie das OXID Backend nicht verwenden, müssen Sie einen Cronjob einrichten.
Kopieren Sie das Cronscript in ein Verzeichnis außerhalb von www.  
Zum Beispiel: `/root/cron/`  
Im Script selbst muss die Domain eingetragen und ein Zugang für das OXID Backend hinterlegt werden.

Um alle 5 Minuten einen abgleich durchzuführen, fügen Sie folgende Zeile zur Datei /etc/crontab hinzu: 

    */5 *   * * *   root  php5 /root/cron/lfndsdonationobserver.php
    
## Bekannte Probleme
### elefunds Widget erscheint nicht:
bei ältern Shopversionen ist es notwendig eine neuere Version von JQuery zu laden.
Aktivieren Sie diese Einstellung im Modul, sollte das Widget nicht angezeigt werden.
Das Javascript Widget benötigt mindestens jQuery V1.7
