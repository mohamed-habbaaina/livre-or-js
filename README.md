# livre-or-js
#Descriptif du projet

Vous décidez de créer un #livre_d’or permettant à vos utilisateurs de laisser leurs avis sur
votre site. Ce projet doit être réalisé en utilisant les classes notamment pour
représenter vos utilisateurs.
Pour commencer, créez votre #base_de_données nommée “livreor” à l’aide de
phpmyadmin. Dans cette bdd, créez une table “utilisateurs” qui contient les champs
suivants :
- id, int, clé primaire et Auto Incrément
- login, varchar de taille 255
- password, varchar de taille 255
Créez une #table “commentaires” qui contient les champs suivants :
- id, int, clé primaire et Auto Incrément
- commentaire, text
- id_utilisateur, int
- date, datetime
Maintenant que la base de données est prête, vous allez avoir besoin de créer
différentes pages :
- #Une_page_d’accueil qui présente votre site (index.php)
- Une page contenant un #formulaire_d’inscription et un un formulaire de
#connexion. La connexion et l’inscription doivent se faire en #asynchrone avec
Javascript. La validation des formulaires doit se faire #sans_rechargement de
page (Utilisateur existant, mot de passe non confirmé, etc).
- Une page permettant de modifier son #profil (profil.php) :
Cette page possède un formulaire permettant à l’utilisateur de modifier son login
et son mot de passe sans rechargement de page.
- Une page permettant de voir le #livre_d’or (livre-or.php) :
Sur cette page on voit l’ensemble des commentaires, organisés du plus récent
au plus ancien. Chaque commentaire doit être composé d’un texte “posté le
`jour/mois/année` par `utilisateur`” suivi du commentaire. Si l’utilisateur est
connecté, sur cette page figure également un lien vers la page d’ajout de
commentaire.
- Un formulaire #d’ajout_de_commentaire (commentaire.php) :
Ce formulaire ne contient qu’un champ permettant de rentrer son commentaire et
un bouton de validation. Il n’est accessible qu’aux utilisateurs connectés. Chaque
utilisateur peut poster plusieurs commentaires.
Votre site doit avoir une structure html correcte et un design soigné à l’aide de css.
Vous avez la liberté de choisir un thème à l’image de votre groupe.
Vous devez également rendre la structure et le contenu de votre base de données dans
un fichier nommé “livreor.sql”.