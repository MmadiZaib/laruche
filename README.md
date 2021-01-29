## Installation du projet 

Pour tester le projet sur votre environnement local, il est conseillé d'avoir docker installé car le projet est dockérisé

1 - Cloner le projet : `git clone `

2 - `cd laruche_test`

3 - `docker-compose up -d`

4 - Installer les packages : `./scripts/composer install`

5 - Charger les fixtures: `./scripts/fixtures`

6 - Lancer les tests: `./scripts/tests`
  

## Test de l' API   

##### Pour Uploader le fichier de stock et enregister les données dans la base de données:

L'api est sécurisée par Authenfication JWT. Pour tester l'api il faut faire les étapes suivantes :

- Générer un token : ```curl -X POST -H "Content-Type: application/json" http://localhost/api/login_check -d '{"username":"laruche@test.com","password":"laruche"}'```

- uploader le fichier : 
  ``` 
  curl -X POST -F  gift_file="@/your_project_dir_path/exemple_usine_A.csv" -H "Authorization: Bearer  YOUR_TOKEN_GENERATED_BEFORE" -F _method=POST http://localhost/api/populate
  ```

##### Pour Afficher les statistiques:

- Affichage des statistiques:
  ``` 
  curl -X GET  -H "Authorization: Bearer  YOUR_TOKEN_GENERATED_BEFORE" -F _method=POST http://localhost/api/stats
  ```

## Étapes de réalisation du projet

- 1 / Création du projet symfony en utilisant ``symfony/skeleton`` afin d'avoir que les compoasants dont j'ai besoin.
- 2 / Installation du package doctrine en utilisant flex : ```composer require doctrine ``` et ``composer require orm``
- 3 / Installation du maker-bundler pour accélérer le processus de dev : ```composer require make-bundle```
- 4 / Installation de ```FOSRESTUNDLE``` pour la création de l'api rest et ``LexitJWTAuthentificationBundle``  pour l'authentification JWT.
- 5 / Installation de l' ``orm-fixtures`` pour la création de fixtures de l'entité ``USER``


Merci 


