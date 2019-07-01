# Quand le blog Bière rencontre le MVC :

## Etape n°1 :

- Clone du [Repo Site Biere Revival](https://github.com/BenjaminSiskoo/Site-Biere-Revival) et clone du [Repo New Blog MVC](https://github.com/BenjaminSiskoo/NewBlogMVC) 

## Etape n°2 :

- Récupération de la dernière version d'adminer.php depuis le [Site Adminer.org](https://www.adminer.org/) et installation dans le dossier www.public de New Blog MVC.
- Copie du fichier .env.sample en .env

## Etape n°3 :

- Récupération/Modification des requêtes SQL de Site Biere Revival et intégration dans le createsql.sql du New Blog MVC

## Etape n°4 :

- Après avoir lancé ./start.sh pour lancer le docker, ouverture du localhost/adminer.php
- Vérification de l'intégration des tables beer, orders, users dans adminer. Ainsi que l'intégration des données.

## Etape n°5 :

- Création de la route pour afficher l'index du site bière www/public/index.php.
- Création du fichier BeerController.php dans www/src/Controller/BeerController.php. Inclusion de la méthode home().
- Création du dossier sitebeer dans www/views/. Création du fichier home.twig qui permet d'afficher le contenu.

## Etape n°6 :

- Création de la route pour afficher la page de la boutique.
- Ajout de la méthode all() dans le fichier BeerController.php.
- Création du fichier boutique.twig qui permet d'afficher les bières.
- Ajout de la méthode AllBylimit dans le fichier Core/Model/Table.

## Etape n°7 :

- Création de la route pour afficher la page inscription.
- Création de la route pour afficher la page boutique.
- Création du fichier de vue signin.twig.
- Création du fichier de vue signup.twig.
- Correction de l'affichage des articles du blog en mode portable et tablette
- Correction du menu burger du Blog en ajoutant les liens JS de boostrap.
- Ajout du session_start dans App.php afin d'initialiser la session au chargement de l'application.
- Installation de swiftmailer.
- Dans UserTable.php, ajout des méthodes verifMail(), confirmMail(), updateVerifyMail(), userConnect().
- Création de MailController dans Core\Controller\Helpers\MailController.php. Création de la méthode sendMail().
- Création de l'URL pour la page de déconnexion.

# Etape n°8 :