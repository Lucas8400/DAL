<?php
class Middleware {
    // Méthode pour gérer la requête
    public function handle($request) {
        // Vérifier si l'action est valide
        if (!$this->isValidAction($request['action'])) {
            // Si l'action n'est pas valide, générer une exception avec un message d'erreur
            throw new Exception("Action non autorisée ou invalide.");
        }

        // Vérifier si les données sont valides pour l'action demandée
        if (!$this->validateData($request['action'], $request['data'])) {
            // Si les données ne sont pas valides, générer une exception avec un message d'erreur
            throw new Exception("Données invalides pour l'action demandée.");
        }

        // Si tout est valide, retourner true (indiquant que la requête est traitée avec succès)
        return true;
    }

    // Méthode pour vérifier si l'action est valide
    private function isValidAction($action) {
        // Actions valides
        $validActions = ['ajouter', 'supprimer', 'modifier'];

        // Vérifier si l'action est dans la liste des actions valides
        return in_array($action, $validActions);
    }

    // Méthode pour valider les données en fonction de l'action
    private function validateData($action, $data) {
        switch ($action) {
            case 'ajouter':
                // Valider les données pour l'action "ajouter"
                return $this->validateAddData($data);
            case 'supprimer':
                // Valider les données pour l'action "supprimer"
                return $this->validateDeleteData($data);
            case 'modifier':
                // Valider les données pour l'action "modifier"
                return $this->validateUpdateData($data);
            default:
                // Si l'action n'est pas reconnue, retourner false (données invalides)
                return false;
        }
    }

    // Méthode pour valider les données pour l'action "ajouter"
    private function validateAddData($data) {
        // Vérifier si les clés 'prenom' et 'nom' existent dans les données
        return isset($data['prenom']) && isset($data['nom']);
    }

    // Méthode pour valider les données pour l'action "supprimer"
    private function validateDeleteData($data) {
        // Vérifier si la clé 'id' existe dans les données
        return isset($data['id']);
    }

    // Méthode pour valider les données pour l'action "modifier"
    private function validateUpdateData($data) {
        // Vérifier si la clé 'id' existe dans les données et si au moins l'une des clés 'prenom' ou 'nom' existe
        return isset($data['id']) && (isset($data['prenom']) || isset($data['nom']));
    }
}

