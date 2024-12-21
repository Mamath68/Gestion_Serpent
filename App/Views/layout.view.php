<?php use App\config\Session;
	
	global $title;
	global $meta_description;
	global $content;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $meta_description ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c01b4bae7d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>css/style.css">
    <link rel="shortcut icon" href="<?= PUBLIC_DIR ?>favicon.ico" type="image/x-icon">
    <title><?= $title ?></title>
</head>

<body class="d-flex flex-column min-vh-100">
<header>
    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container">
            <a class="navbar-brand link-light" href="index.php?ctrl=home&action=index">Serfa RPG</a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas bg-secondary offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                 aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Mon Framework</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link link-light "
                               href="index.php?ctrl=home&action=index">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-light" href="index.php?ctrl=zoo&action=index">Les Cartes de
                                Skills</a>
                        </li>
                    </ul>
                    <div class="d-flex mt-2">
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="container flex-fill">
    <!-- c'est ici que les messages (erreur ou succès) s’affichent-->
    <h3 class="message" style="color: red"><?= Session::getFlash( "error" ) ?></h3>
    <h3 class="message" style="color: green"><?= Session::getFlash( "success" ) ?></h3>
	<?= $content ?>
</main>

<footer class="bg-secondary text-center text-light py-4 px-auto">
    &copy; <?= date_create()->format( "Y" ) ?> Framework Maison Mathieu Stamm
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="<?= PUBLIC_DIR ?>js/script.js"></script>
</body>

</html>
