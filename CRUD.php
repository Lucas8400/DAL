<?php
class CRUD {
    private $db;
    private $table;

    public function __construct($db, $table) {
        $this->db = $db;
        $this->table = $table;
    }

    // Méthode pour créer un enregistrement dans la table
    public function create($data) {
        // Vérifier si la clé 'action' existe dans les données et la supprimer
        if (isset($data['action'])) {
            unset($data['action']);
        }

        // Créer une chaîne de clés pour la requête SQL
        $keys = implode(", ", array_keys($data));
        // Créer une chaîne de valeurs liées pour la requête SQL
        $values = ":" . implode(", :", array_keys($data));
        // Créer la requête SQL d'INSERT
        $sql = "INSERT INTO $this->table ($keys) VALUES ($values)";

        // Préparer la requête SQL
        $stmt = $this->db->prepare($sql);
        foreach ($data as $key => $value) {
            // Associer chaque valeur aux paramètres de la requête SQL
            $stmt->bindValue(":$key", $value);
        }
        // Exécuter la requête SQL
        $stmt->execute();
        // Retourner l'identifiant de la dernière ligne insérée
        return $this->db->lastInsertId();
    }

    // Méthode pour lire des enregistrements de la table
    public function read($conditions = [], $fields = '*') {
        // Construire la requête SQL SELECT avec des conditions éventuelles
        $sql = "SELECT $fields FROM $this->table";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_map(function($k) { return "$k = :$k"; }, array_keys($conditions)));
        }

        // Préparer la requête SQL
        $stmt = $this->db->prepare($sql);
        foreach ($conditions as $key => $value) {
            // Associer chaque valeur aux paramètres de la requête SQL
            $stmt->bindValue(":$key", $value);
        }
        // Exécuter la requête SQL
        $stmt->execute();
        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour mettre à jour des enregistrements dans la table
    public function update($data, $conditions) {
        // Créer une chaîne de champs à mettre à jour
        $updateFields = implode(", ", array_map(function($k) { return "$k = :$k"; }, array_keys($data)));
        // Construire la requête SQL UPDATE avec des conditions éventuelles
        $sql = "UPDATE $this->table SET $updateFields";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_map(function($k) { return "$k = :where_$k"; }, array_keys($conditions)));
        }

        // Préparer la requête SQL
        $stmt = $this->db->prepare($sql);
        foreach ($data as $key => $value) {
            // Associer chaque valeur aux paramètres de la requête SQL
            $stmt->bindValue(":$key", $value);
        }
        foreach ($conditions as $key => $value) {
            // Associer chaque valeur de condition aux paramètres de la requête SQL
            $stmt->bindValue(":where_$key", $value);
        }
        // Exécuter la requête SQL
        $stmt->execute();
        // Retourner le nombre de lignes mises à jour
        return $stmt->rowCount();
    }

    // Méthode pour supprimer des enregistrements de la table
    public function delete($conditions) {
        // Construire la requête SQL DELETE avec des conditions éventuelles
        $sql = "DELETE FROM $this->table";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_map(function($k) { return "$k = :$k"; }, array_keys($conditions)));
        }

        // Préparer la requête SQL
        $stmt = $this->db->prepare($sql);
        foreach ($conditions as $key => $value) {
            // Associer chaque valeur de condition aux paramètres de la requête SQL
            $stmt->bindValue(":$key", $value);
        }
        // Exécuter la requête SQL
        $stmt->execute();
        // Retourner le nombre de lignes supprimées
        return $stmt->rowCount();
    }
}

