# elefunds-OXID

The elefunds OXID module.  

## Installationsanleitung für elefunds OXID Modul V.4.7.0 - 4.8.x

1. Kopieren Sie alle Dateien aus copy_this in ihr Shop root Verzeichnis.
2. Aktivieren Sie das Modul im Backend unter Erweiterungen > Module > Elefunds.
3. Moduleinstellungen vornehmen und [elefunds API Zugang](https://elefunds.de/produkt/anmeldung/) eintragen
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
einen [Cronjob einrichten](cron/).

## Bekannte Probleme
### elefunds Widget erscheint nicht:
bei ältern Shopversionen ist es notwendig eine neuere Version von JQuery zu laden.
Aktivieren Sie diese Einstellung im Modul, sollte das Widget nicht angezeigt werden.
Das Javascript Widget benötigt mindestens jQuery V1.7
