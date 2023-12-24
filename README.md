Projet de Gestion d'Utilisateurs avec CRUD


Ce projet est une application PHP de gestion d'utilisateurs qui utilise les opérations CRUD (Create, Read, Update, Delete) pour interagir avec une base de données MySQL. Il permet d'ajouter, de lire, de mettre à jour et de supprimer des utilisateurs de la base de données.

Configuration

Avant de commencer à utiliser l'application, assurez-vous de configurer correctement les informations de votre base de données dans le fichier Config/config.php.
phpCopy code
// Config/config.php return [ 'db' => [ 'host' => 'localhost', 'dbname' => 'nom_de_votre_base_de_donnees', 'user' => 'votre_nom_utilisateur', 'password' => 'votre_mot_de_passe', ], ]; 
Assurez-vous également d'avoir créé la table appropriée dans votre base de données avec les colonnes id, prenom et nom (ou ajustez le nom de la table et des colonnes selon vos besoins).

Utilisation

L'application propose trois actions principales :

1.	Ajouter un utilisateur :
   
http://localhost/DAL/index.php?action=ajouter&prenom=Prénom&nom=Nom

4.	Supprimer un utilisateur par ID :

http://localhost/DAL/index.php?action=supprimer&id=ID 

6.	Modifier un utilisateur par ID :

http://localhost/DAL/index.php?action=modifier&id=ID&prenom=NouveauPrenom&nom=NouveauNom 

Veillez à remplacer localhost/DAL par l'URL de votre application.


Points clés du projet

•	Gestion des Credentials : Les informations de connexion à la base de données sont stockées de manière sécurisée dans le fichier de configuration.
•	CRUD (incl. Endpoints) : L'application prend en charge les opérations CRUD complètes avec des points d'extrémité correspondants.
•	Filtrage : Le code effectue des vérifications et des filtrages pour garantir la validité des données et des actions.
•	Respect des Standards (incl. Cyber) : Le code suit des bonnes pratiques de codage et de sécurité.
•	Propreté du Code/Maintenabilité : Le code est organisé de manière modulaire et commenté pour faciliter la maintenance.
•	Performance/Ingéniosité : Le code est conçu pour être efficace et fonctionnel.

