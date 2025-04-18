# 🐍 Snake Management System

Une application PHP orientée objet permettant de gérer une base de données de serpents avec les fonctionnalités
suivantes :

- Ajout, modification, suppression de serpents (CRUD)
- Filtrage par **genre** et **race**
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

> Possibilité d'importer le fichier init.sql(qui se trouve dans le dossier sql(rangé dans public)) dans phpmyadmin ou
> tout autre sgbd que vous utilisez.

> Si vous souhaitez avoir déja des serpents, je vous invite à utiliser le fichier serpents.sql situé au même endroid que
> le précédent fichier cité.

### 3. Ouvrez App\Config/Database.php et modifier la ligne 22 à 26 :

```php
$dbhost = "127.0.0.1";
$dbport = 3306;
dbname = "snakes_db";
$dbuser = "";
$dbpass = "";
```

### 4. Avant de lancer l'application

J'ai utiliser composer pour l'autoloader, vous devrez de ce fait effectuer un :

```bash
  composer install
```

### 5. Lancer l'application

Si vous utilisez wamp, xamp ou un outil similaire, ouvrez simplement http://localhost:8000 dans votre navigateur.

Sinon, vous pouvez demarrer un serveur interne dans votre ide.

```bash
  php -S localhost:8080 -t public/
```
Puis, vous faire pareil, ouvrez http://localhost:8080 dans votre navigateur.
