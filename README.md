# Prueba Tecnica - 2o2

## Requisitos Previos
Docker

## Instalación
Arrancar powershell y situarse en la carpeta raiz donde se ubica el fichero docker-compose.yml y ejecutar el comando:

docker compose up -d

Situarse en la carpeta app y ejecutar el comando:

composer install

Peticiones disponibles:
http://localhost:8080/api/beers?food=Spicy
http://localhost:8080/api/beer/5

Acceder a http://localhost:8080/api/doc
