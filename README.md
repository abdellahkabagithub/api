API : (Interface de programmation d'application)
REST :  ((Representational State Transfert) est un style d'architecture logicielle définissant un ensemble de contraintes à utiliser pour créer un service web)
#JSON : (JavaScript Object Notation) est un format standard qui permet de représenter des données structurées de façon semblable aux objets JavaScript
## Les prérequis : 
php artisan migrate
## les controlers d'api
php artisan make:controller API/UserController --model=User --api
## --api :
permet de creer (## index, store, show, update et destroy)
## Les routes de l'Api
faite php artisan route:list
