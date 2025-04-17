<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous"/>
    <link rel="stylesheet" href="<?= STYLE_DIR ?>/style.css"/>
    <title>Erreur <?= $code ?></title>
</head>
<body class="bg-light d-flex flex-column justify-content-center align-items-center vh-100">
<?php if( !file_exists( $errorView ) ) {
	$title = "Erreur $code - Page non disponible.";
	$message = "La page d'erreur personnalisée pour le code $code est manquante.";
	require VIEW_DIR . "/layout/error_base.html.php";
	return;
} ?>
<div class="text-center">
    <h1 class="display-1 text-danger"><?= $code ?></h1>
    <h2 class="mb-3"><?= $title ?></h2>
    <p class="lead"><?= $message ?></p>
    <a href="index.php?page=list" class="btn btn-primary mt-3">Retour à l'accueil</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
        integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
<script src="<?= SCRIPT_DIR ?>/script.js"></script>
</body>
</html>
