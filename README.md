# e-commerce

Ce projet scolaire du groupe IPSSI consiste à créer un site de e-commerce avec Symfony. Les consignes suivantes nous ont été données.

Création Du Projet
Pour travailler à 2 sur le projet, il faut qu’un des membres créé le projet
et le partage sur GitHub, puis que le second membre récupère ce projet.
A partir de là vous pouvez commencer à coder.
Entités
Vous aurez besoin des entités suivantes:
Produit
Vous devez avoir une entité produit qui contient les informations
suivantes :
- Nom
- Description
- Prix
- Stock
- Photo
Utilisateur
Vous devez stocker :
- Nom
- Prénom
- Email
- Mot de passe
- Roles 
Panier
Cette entité stock les achats des utilisateurs.
Vous devez y stocker :
- Utilisateur (relation vers la table Utilisateur)
- Date d’achat (la date de l’achat)
- Etat (false par défaut, true dès que c’est payé)
ContenuPanier
Cette entité contient le contenu de chaque panier.
Vous devez y stocker :
- Produit (relation vers la table Produit)
- Panier (relation vers la table Panier)
- Quantité (quantité commandée)
- Date (date de l’ajout au panier)
Pages
Vous devez réaliser les pages suivantes :
Accueil
Liste des produits.
Au clic d’un produit on arrive sur la fiche du produit.
Si vous êtes connecté avec un rôle ROLE_ADMIN, vous devez pouvoir
ajouter un produit sur cette page.
Fiche produit
Cette page affiche le contenu d’un produit.
Il doit être possible d’ajouter le produit au panier à partir de cette page à
condition d’être connecté. L’utilisateur connecté doit automatiquement
être attribué à la commande.
Si vous êtes connecté avec un rôle ROLE_ADMIN, vous devez pouvoir
modifier ou supprimer le produit. 
Panier
Cette page liste les produits du panier de l’utilisateur.
Attention à afficher uniquement les produits du panier en cours (non
payé) de l’internaute connecté.
Chaque ligne du panier doit posséder les informations suivantes :
- Nom du produit
- Quantité commandée
- Prix du produit
- Montant de la ligne,
- Un bouton de suppression du produit du panier.
La page doit afficher le montant total du panier et un bouton permettant
d’acheter le panier.
Mon compte
Cette page doit permettre à l’internaute de modifier son profil et doit
afficher l’historique de ses commandes.
L’historique des commandes doit afficher pour chaque ligne :
- L’identifiant de la commande,
- Le montant de la commande,
- La date de la commande (stockée automatiquement en base, ça ne
doit apparaître dans aucun formulaire).
Au clic d’une commande, on doit arriver sur une page qui affiche le
contenu de la commande.
Contenu de la commande
Cette page affiche le contenu de la commande.
Vous pouvez utiliser le même tableau que la page Panier, en affichant
en plus, la date de la commande (et sans l’option d’achat).
Le SUPER_ADMIN
Vous devez mettre en place un rôle ROLE_SUPER_ADMIN qui doit
posséder les même droits que le ROLE_ADMIN mais il doit pouvoir en
plus : 
1/ lister les paniers non achetés, avec pour chacun :
- l'utilisateur à qui appartient le panier,
- le numéro du panier,
- le contenu du panier
2/ afficher les utilisateurs inscrits aujourd'hui du plus récent au plus
ancien
Contraintes
- Les menus et pages doivent être adaptés au rôle de l'internaute
connecté.
- Les pages d’erreur doivent être personnalisées.(403, 404, 500 et
défaut)
- Votre code doit être commenté.
- Les formulaires doivent faire l’objet de validation des données
(constraints)
- Vous devez utiliser des messages Flash indiquant le succès ou l’échec
des actions.  

######################################################################################################

Démarrer le serveur : 
symfony server:start
