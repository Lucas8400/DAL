<?php
// Inclure les fichiers nécessaires
require_once 'database.php';
require_once 'middleware.php';
require_once 'CRUD.php';

// Établir une connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Vérifier si la connexion à la base de données a réussi
if ($db) {
    // Créer une instance de la classe CRUD pour la table 'utilisateurs'
    $crud = new CRUD($db, 'utilisateurs');
} else {
    die("Erreur de connexion à la base de données.");
}

// Créer une instance de la classe Middleware
$middleware = new Middleware();

// Obtenir la méthode de la requête HTTP
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Obtenir le chemin de la requête
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);

// Créer un tableau de données de la requête
$request = ['action' => $_GET['action'] ?? '', 'data' => $_GET];

try {
    // Gérer la requête avec le middleware
    $middleware->handle($request);

    // Traiter la requête en fonction de l'action spécifiée
    switch ($request['action']) {
        case 'ajouter':
            $id = $crud->create($request['data']);
            echo json_encode(['id' => $id]);
            break;

        case 'supprimer':
            $id = $_GET['id'];
            $crud->delete(['id' => $id]);
            echo json_encode(['message' => 'Utilisateur supprimé']);
            break;

        case 'modifier':
            $id = $_GET['id'];
            $nouveauPrenom = $_GET['prenom'];
            $nouveauNom = $_GET['nom'];

            // Préparer les données à mettre à jour
            $data = ['prenom' => $nouveauPrenom, 'nom' => $nouveauNom];

            // Mettre à jour l'utilisateur
            $crud->update($data, ['id' => $id]);
            echo json_encode(['message' => 'Utilisateur mis à jour']);
            break;

        default:
            // Répondre avec un code d'erreur 404 si l'action n'est pas trouvée
            http_response_code(404);
            echo json_encode(['error' => 'Action non trouvée']);
            break;
    }
} catch (Exception $e) {
    // Répondre avec un code d'erreur 500 en cas d'exception
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

