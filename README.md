Das Projekt kann mit Folgendem Docker Befehl gestartet werden:  
docker compose up -d --build

Danach sollte alles funktionieren.  
Manchmal kann es aber ein wenig dauern, bis der App Container, den DB-Container erkennt im Entrypoint.sh skript.

Die Logs vom App Container können so eingesehen werden:  
docker compose logs -f app  
Zum Überprüfen, ob die Container überhaupt laufen kann man diesen Befehl verwenden:  
docker compose ps

Zunächst sollte sich ein API-Token gezogen werden unter der Route:  
http://127.0.0.1/api/token/create

Der standard Benutzer, der mit dem Befehl "php artisan db:seed" generiert wird, hat folgende Credentials:  
username: test  
pw: 1234

![Aufgaben](/public/aufgaben.png)

Es gibt folgende API Routen:
GET:  
http://127.0.0.1/api/aufgaben  
http://127.0.0.1/api/aufgaben/overdue
http://127.0.0.1/api/aufgaben/{aufgabe}
http://127.0.0.1/api/projekte/{projekt}/aufgaben
http://127.0.0.1/api/token/create
http://127.0.0.1/api/user/{user}/aufgaben


POST:  
http://127.0.0.1/api/aufgaben  
beispiel: 
{  
    "title" : "string",  
    "description" : "string",  
    "deadline" : "1970-01-01 00:00:00"  
    "status" : 1  
}

PATCH:  
http://127.0.0.1/api/aufgaben/{aufgabe}  
beispiel:  
{  
    "status" : 2  
}

DELETE:  
http://127.0.0.1/api/aufgaben/{aufgabe}  
