<?php
// Inclure la configuration de la base de données et les id de connexion
require_once 'Config/config.php';

class Database {
    // Propriétés pour stocker les informations de connexion à la base de données
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn; // L'objet de connexion à la base de données

    public function __construct() {
        // Récupérer les informations de connexion depuis la configuration
        $config = require('Config/config.php');
        $this->host = $config['db']['host'];
        $this->db_name = $config['db']['dbname'];
        $this->username = $config['db']['user'];
        $this->password = $config['db']['password'];
    }

    public function getConnection() {
        $this->conn = null; // Initialiser la connexion à null

        try {
            // Créer une nouvelle instance de PDO pour établir la connexion
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

            // Définir le jeu de caractères de la connexion en UTF-8
            $this->conn->exec("set names utf8");

            // Activer le mode d'affichage des erreurs en mode exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // En cas d'erreur, afficher un message d'erreur
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        // Retourner l'objet de connexion à la base de données
        return $this->conn;
    }
}

