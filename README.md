# FiveMods.net
![Webserver CI/CD Service Live](https://github.com/FiveMods/main/workflows/Webserver%20CI/CD%20Service/badge.svg?branch=live)

The best platform for the best mods, scripts and maps.

## Monetization 
- Normal: ( bis 15€ ), prozentualer Anteil ( -30% ), download Anteil ( 1€ pro 5k downloads ) 
- Partner: ( 5k Downloads ) -> höherer prozentualer Anteil ( -15% ), höheres Limit ( - unbegrenzt ), download Anteil ( 2€ pro 5k downloads )

# Still ToDo:

## Admin Menu
- Partner requests annehmen / ablehnen
- Log, damit wir sehen, wer was macht (falls wir mal mods haben lol)
- FaQ Fragen hinzufügen / bearbeiten / übersetzen
- Profile sperren / (löschen)
- Mods deaktivieren (aber anzeigen, dass sie gelöscht sind lol)
- Kontaktnachrichten sollten dort angezeigt werden
- Reported Profiles / Mods

## Upload
- Tags, je nach auswahl der Tags ändern

## What to change (Feedback)
- Please have a look into the issues tab in github

ca. 20€ pro 5000 views
Partner bekommen 25% mehr pro 5000 downloads pro mod

Er bekommt eigene DB
Eigene GitHub Branch

Alle datenbank connections mit den anmeldedaten in eine File
Die File muss extern liegen

Philipp: 
- Edit / Delete Mod
    |-> Payment leichte dinge
- 2FA fixen / fertig machen

Oetkher: 
- ACP finishen
- Upload finishen

Zwei von uns müssen payment approven

Payment DB

payment_log
- payment_id
- payment_userid
- payout
- maintainer
- datum

payment_user
- payment_userid
- uuid
- name
- vorname
- geburtsdatum
- paypal-mail
- personal-mail
- anschrift
- bild von dokument