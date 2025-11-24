Das Projekt kann mit Folgendem Docker Befehl gestartet werden:  
docker compose up -d --build

Danach sollte alles funktionieren.  
Manchmal kann es aber ein wenig dauern, bis der App Container, den DB-Container erkennt im Entrypoint.sh skript.

Zunächst sollte sich ein API-Token gezogen werden unter der Route:  
http://127.0.0.1/token/create

Der standard Benutzer, der mit dem Befehl "php artisan db:seed" generiert wird, hat folgende Credentials:  
username: test  
pw: 1234

![Aufgaben](/public/aufgaben.png)

Es gibt folgende API Routen:
GET:  
http://127.0.0.1/aufgaben  
http://127.0.0.1/aufgaben/{aufgabe}

POST:  
http://127.0.0.1/aufgaben  
beispiel: {
    "title" : "string",
    "description" : "string",
    "status" : 1
}

PATCH:  
http://127.0.0.1/aufgaben/{aufgabe}

beispiel: {
    "status" : 2
}

DELETE:  
http://127.0.0.1/aufgaben/{aufgabe}  
