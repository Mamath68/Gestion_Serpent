# 🐍 Snake Management System

Une application PHP orientée objet permettant de gérer une base de données de serpents avec les fonctionnalités suivantes :
- Ajout, modification, suppression de serpents (CRUD)
- Filtrage par **genre** et **race** (sélection stricte)
- Accouplement de serpents
- Visualisation de l’**arbre généalogique** (parents, grands-parents, frères/sœurs, oncles/tantes, descendants)

---

## Installation & lancement

### 1. Prérequis

- PHP 8.4
- Serveur web (Apache ou Nginx)
- MySQL ou MariaDB
- Navigateur moderne

### 2. Initialisation de la base de données

> Possibilité de soit déposer le fichier init.sql situé dans sql directement dans l'outil (phpMyAdmin). 

> Si vous souhaitez avoir déja des serpents, utilisé plutôt le fichier serpents.sql situé dans le dossier sql.

### 3. Ouvre config/Database.php et modifier la ligne 13 à 17 :

```php
$host = 'localhost';
$db = 'snakes_db';
$user = 'root';
$pass = '';
```

### 4. Lancer l'application

Puis ouvre http://localhost:8000 dans ton navigateur.
