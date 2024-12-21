<?php

require_once 'Config/DAO.php';
require_once 'Config/CreateTable.php';

use App\config\CreateTable;
use App\config\DAO;

// Connexion à la base de données
DAO::connect();

// Vérifier si le nom de la table est passé en argument
$tableName = $argv[1] ?? 'users'; // Valeur par défaut : 'users'

// Instancier CreateTable et créer la table avec le nom spécifié
$creator = new CreateTable();
$creator->createTable(DAO::$bdd, $tableName);
