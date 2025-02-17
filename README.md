## Logs Utilisateur

Nom = user
Mot de passe = password

## Logs Administrateur

Nom = admin
Mote de passe = password

## Déploiement en local

Pour déployer en local ajouter dossier au répertoire www de wamp et créer virtual host avec le dossier public du projet en chemin d'accés.
Créer database MariaDB "$symfony console doctrine:database:create" puis charger fixtures "$symfony console doctrine:fixtures:load"
Puis lancer l'application.

## Screens de test d'achat dans dossier Stubborn stripe payment screens  
