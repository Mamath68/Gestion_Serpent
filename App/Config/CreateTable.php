<?php

namespace App\Config;

use PDOException;

class CreateTable
{
    /**
     * @param $pdo
     * @param string $tableName
     * @return void
     */
    public function createTable($pdo, string $tableName): void
    {
        // Requête SQL pour créer la table, avec le nom de table personnalisé
        $query = "
            CREATE TABLE IF NOT EXISTS $tableName (
                id INT AUTO_INCREMENT PRIMARY KEY,
                ref VARCHAR(255) NOT NULL,
                titre VARCHAR(255) NOT NULL,
                auteur VARCHAR(255) NOT NULL,
                description LONGTEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ";

        try {
            $pdo->exec($query);
            echo "La table '$tableName' a été créée avec succès.\n";
        } catch (PDOException $e) {
            echo "Erreur lors de la création de la table '$tableName' : " . $e->getMessage();
        }
    }
}
