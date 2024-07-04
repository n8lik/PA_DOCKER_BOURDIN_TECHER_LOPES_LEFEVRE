Branche dockercomposeonly comportant uniquement le docker-compose ainsi que le dossier secret permettant de lancer les conteneurs.

A noter qu'il y a la branche main comportant tout le code source ainsi que les Dockerfile.

Pour lancer les conteneurs docker :

Avoir Docker composer installé sur sa machine

Avoir git 



git remote add origin https://github.com/n8lik/PA_DOCKER_BOURDIN_TECHER_LOPES_LEFEVRE

git fetch origin dockercomposeonly

git switch dockercomposeonly

docker-compose up -d
