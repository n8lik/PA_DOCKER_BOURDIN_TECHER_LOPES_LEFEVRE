Branche MAIN contenant le code source de l'application ainsi que les Dockerfile (un dans API un dans le dossier Racine) ainsi que le docker-compose (dans le dossier racine)

A noter qu'il y a une branche dockercomposeonly avec uniquement le nécessaire pour lancer les conteneurs (il n'y pas besoin du code source)


Pour lancer les conteneurs docker :


Avoir Docker composer installé sur sa machine (!!!!!!!VERSION DE DOCKER COMPOSE IMPORTANTE IL FAUT LA NOUVELLE !!!!!!!!!) :  https://docs.docker.com/engine/install/debian/ 

Avoir git


git clone https://github.com/n8lik/PA_DOCKER_BOURDIN_TECHER_LOPES_LEFEVRE.git votrechemin

cd votrechemin

docker compose up -d
