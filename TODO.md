# BOUTIQUE

## 1 Création de la base de données
1. Créer la base de données nommée `boutique_konexio` avec les tables suivantes :
- produit:
    - id_produit(int, auto_increment primary key)
    - reference(varchar(100) unique)
    - categorie(varchar(100))
    - titre(varchar(100))
    - description(text)
    - couleur(varchar(20))
    - taille(varchar(10))
    - public(enum('m', 'f', 'mixte', 'enfant'))
    - photo(varchar(255))
    - prix(int)
    - stock(int)
- membre:
    - id_membre(int, auto_increment primary key)
    - pseudo(varchar(50) unique)
    - mdp(varchar(100))
    - nom(varchar(100))
    - prenom(varchar(100))
    - email(varchar(100) unique)
    - civilite(enum('m', 'f'))
    - statut(int) // 0 = membre, 1 = admin 
    - adresse(varchar(255))
    - code_postal(int 5 unsigned zerofill)
    - ville(varchar(100))
    - pays(varchar(100))
- commande:
    - id_commande(int, auto_increment primary key)
    - id_membre(int)
    - montant(int)
    - date_enregistrement(datetime) CURRENT_TIMESTAMP
    - etat(enum('en cours', 'validé', 'expédié', 'livré'))
- details_commande:
    - id_details_commande(int, auto_increment primary key)
    - id_commande(int)
    - id_produit(int)
    - quantite(int)
    - prix(int)


## 2 Création du menu
1. Créer un fichier `index.php` le menu du site avec les liens suivants : 
- Accueil
- Boutique
- Contact
- Inscription
- Connexion
- Profil
- Déconnexion
- Panier
- Administration

## 3 Création de la page d'accueil
1. Faire la page d'accueil du site avec un slider qui affiche les  produits ajoutés à la boutique.

## 4 Mettre en place la structure de la boutique


## 5 Création de la page d'inscription
1. Faire la page d'inscription avec un formulaire qui permet d'insérer les données dans la table `membre` de la base de données `boutique_konexio`. Vous devez vérifier que les données saisies sont correctes et informer l'utilisateur en cas d'erreur avec un message d'erreur clair et précis.Faire la vérification de tous les champs du formulaire.Et si tout est ok hashé le mot de passe avec la fonction `password_hash()` et insérer les données dans la base de données.


## 6 Création de la page de connexion
1. Faire la page de connexion avec un formulaire qui permet de vérifier si l'utilisateur existe dans la base de données et si le mot de passe est correct. Si tout est ok, on redirige l'utilisateur vers la page profil du site. Si l'utilisateur n'existe pas ou que le mot de passe est incorrect, on affiche un message d'erreur clair et précis.

## 7 Création de la page de profil
1. Faire la page de profil avec les informations de l'utilisateur connecté. Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion.

## 8 Création de la page de déconnexion
1. Faire la page de déconnexion qui permet de déconnecter l'utilisateur et de le rediriger vers la page d'accueil du site.

## 9 Création de la page de contact
1. Faire la page de contact avec un formulaire qui permet d'envoyer un message à l'administrateur du site. Vous devez vérifier que les données saisies sont correctes et informer l'utilisateur en cas d'erreur avec un message d'erreur clair et précis. Faire la vérification de tous les champs du formulaire.

## 10 Création de la page administration du site (back-office)
1. Faire la page d'administration du site avec un menu qui permet d'accéder aux différentes pages d'administration du site. Le menu doit être différent de celui du site. Il doit contenir les liens suivants : 
- Gestion des produits
- Gestion des membres
- Gestion des commandes

Dans le fichier `function.php` faire une fonction qui permet de vérifier si l'utilisateur est connecté et est administrateur. Si l'utilisateur n'est pas connecté ou n'est pas administrateur, on le redirige vers la page d'accueil du site.

## 11 Création de la page d'administration des produits
1. Faire la page d'administration des produits avec un formulaire qui permet d'ajouter un produit dans la base de données. Vous devez vérifier que les données saisies sont correctes et informer l'utilisateur en cas d'erreur avec un message d'erreur clair et précis. Faire la vérification de tous les champs du formulaire. Vous devez vérifier que le fichier envoyé est bien une image et que le poids du fichier ne dépasse pas 2Mo. Vous devez également vérifier que le fichier n'existe pas déjà dans le dossier `photo` du site. Si tout est ok, vous devez enregistrer le fichier dans le dossier `photo` du site et insérer les données dans la base de données.
2. Faire la page d'administration des produits avec un formulaire qui permet de modifier un produit dans la base de données. 
3. Faire la page d'administration des produits avec un formulaire qui permet de supprimer un produit dans la base de données.
4. Afficher la liste des produits dans un tableau HTML avec les boutons modifier et supprimer.

## 12 Création de la page d'administration des membres
1. Faire la page d'administration des membres qui permet de supprimer un membre dans la base de données ou de voir les commandes d'un membre.

## 13 Création de la page d'administration des commandes
1. Faire la page d'administration des commandes qui permet de voir les détails d'une commande.

## 14 AFFICHAGE DES PRODUITS
1. Affichier tous les produits dans la page d'accueil du site avec un bouton qui permet de voir le produit dans un fichier `ficheProduit.php`.

## 15 AFFICHAGE DES PRODUITS PAR CATEGORIES DANS LA BOUTIQUE
1. Afficher les produits par catégories dans la page boutique du site avec un bouton qui permet de voir le produit dans un fichier `ficheProduit.php`.

