# elefunds-OXID

## Spendenstatus per Cronjob aktualisieren:

Damit der Spendenstatus von bezahlten Spenden auch an die elefunds API gemeldet werden kann, 
wenn Sie das OXID Backend nicht verwenden, müssen Sie einen Cronjob einrichten.
Kopieren Sie das Cronscript in ein Verzeichnis außerhalb von www.  
Zum Beispiel: `/root/cron/`  
Im Script selbst muss die Domain eingetragen und ein Zugang für das OXID Backend hinterlegt werden.

Um alle 5 Minuten einen abgleich durchzuführen, fügen Sie folgende Zeile zur Datei /etc/crontab hinzu: 

    */5 *   * * *   root  php5 /root/cron/lfndsdonationobserver.php

[Zurück zur Anleitung](/)
