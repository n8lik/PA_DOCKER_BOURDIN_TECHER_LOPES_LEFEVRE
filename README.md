Branche dockercomposeonly comportant uniquement le docker-compose ainsi que le dossier secret permettant de lancer les conteneurs.

A noter qu'il y a la branche main comportant tout le code source ainsi que les Dockerfile. 

Pour lancer les conteneurs docker : 

Avoir Docker composer installé sur sa machine (!!!!!!!VERSION DE DOCKER COMPOSE IMPORTANTE IL FAUT LA NOUVELLE !!!!!!!!!) :  https://docs.docker.com/engine/install/debian/ 

Avoir git 



git https://github.com/n8lik/PA_DOCKER_BOURDIN_TECHER_LOPES_LEFEVRE --branch dockercomposeonly mondossier

cd mondossier

docker compose up -d
