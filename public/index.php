<?php

namespace App;

use App\Config\Autoloader as Autoloader;
use App\Config\Session as Session;
use Exception;

require_once __DIR__ . '/../App/Config/Autoloader.php';
require_once __DIR__ . '/../App/Config/Session.php';
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__DIR__) . DS);
define('VIEW_DIR', __DIR__ . '/../App/Views/');

define('PUBLIC_DIR', "./");

define('DEFAULT_CTRL', 'Home');
Autoloader::register();

try {
    Session::start();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

//---------REQUETE HTTP INTERCEPTÉE-----------
$ctrlname = DEFAULT_CTRL;

if (isset($_GET['ctrl'])) {
    $ctrlname = $_GET['ctrl'];
}
$ctrlNS = "App\\Controller\\" . ucfirst($ctrlname) . "Controller";

if (!class_exists($ctrlNS)) {

    $ctrlNS = "App\\Controller\\" . DEFAULT_CTRL . "Controller";
}

$ctrl = new $ctrlNS();

$action = "index";

if (isset($_GET['action']) && method_exists($ctrl, $_GET['action'])) {

    $action = $_GET['action'];
}
//
$id = $_GET['id'] ?? null;

$name = $_GET['name'] ?? null;



$result = $ctrl->$action($id);

/*--------CHARGEMENT PAGE--------*/

switch ($action) {
    case "ajax":
        echo $result;
        break;
    default:
        ob_start();
        global $title, $meta_description, $content;
        $meta_description = $result['data']['meta_description'] ?? 'Mon Framework Maison';
        $title = $result['data']['title'] ?? 'Mon Framework Maison';
        $viewPath = $result['view'];

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {

            echo "La vue demandée n'existe pas.";
        }

        $content = ob_get_contents();
        ob_end_clean();


        include VIEW_DIR . "layout.view.php";
        break;
}
