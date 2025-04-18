<div class="container">
    <h1 class="text-center mb-4">Bienvenue dans mon Vivarium</h1>
    <div class="row">
        <div class="col">
            <form method="get" class="formulaire">
                <label for="gender" class="form-label">Genre :</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="">Tous</option>
                    <option value="Male" <?= isset( $genre ) && $genre === 'Male' ? 'selected' : '' ?>>
                        Mâles
                    </option>
                    <option value="Femelle" <?= isset( $genre ) && $genre === 'Femelle' ? 'selected' : '' ?>>
                        Femelles
                    </option>
                </select>

                <label for="breed" class="form-label">Race :</label>
                <select name="breed" id="breed" class="form-select">
                    <option value="">Toutes</option>
					<?php foreach( $allBreeds as $breed ): ?>
                        <option value="<?= $breed ?>" <?= isset( $breeded ) && $breeded === $breed ? 'selected' : '' ?>><?= $breed ?></option>
					<?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success">Filtrer</button>
            </form>
        </div>
        <div class="col d-flex justify-content-center align-items-center">
            <form method="post" class="formulaire w-100 max-w-50" action="index.php?page=list">
                <button class="btn btn-primary" type="submit" name="generate">Générer des serpents aléatoires</button>
            </form>
			
			<?php
				$generate = filter_input( INPUT_POST, 'generate', FILTER_SANITIZE_NUMBER_INT );
				if( isset( $generate ) ) {
					$manager->generateRandomSnakes();
					header( "Location: index.php?page=list" );
					exit();
				}
			?>
        </div>
    </div>

    <p>
        <strong>Mâles (Page actuelle) :</strong>
		<?= $maleCount ?> |
        <strong>
            Femelles (Page actuelle) :
        </strong>
		<?= $femaleCount ?>
    </p>
    <p>
        <strong>Mâles (Total) :</strong>
		<?= $totalMales ?> |
        <strong>Femelles (Total) :</strong>
		<?= $totalFemales ?>
    </p>

    <a href="index.php?page=add" class="btn btn-success my-3">
        Ajouter un serpent
    </a>
    <table class="table table-bordered border-primary">
        <thead class="table-primary">
        <tr>
            <th>
                <a href="?sort=name&order=<?= $orderDirection === 'asc' ? 'desc' : 'asc' ?>">Nom</a>
            </th>
            <th>
                <a href="?sort=weight&order=<?= $orderDirection === 'asc' ? 'desc' : 'asc' ?>">Poids</a>
            </th>
            <th>
                <a href="?sort=breed&order=<?= $orderDirection === 'asc' ? 'desc' : 'asc' ?>">Race</a></th>
            <th>
                <a href="?sort=gender&order=<?= $orderDirection === 'asc' ? 'desc' : 'asc' ?>">Sexe</a></th>
            <th>
                <a href="?sort=lifespan&order=<?= $orderDirection === 'asc' ? 'desc' : 'asc' ?>">Durée de vie</a></th>
            <th>
                <a href="?sort=is_dead&order=<?= $orderDirection === 'asc' ? 'desc' : 'asc' ?>">Mort</a></th>
            <th>Actions</th>
            <th>Généalogie</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach( $snakes as $s ): ?>
            <tr>
                <td><?= $s->name ?></td>
                <td><?= $s->weight ?> g</td>
                <td><?= $s->breed ?></td>
                <td><?= ucfirst( $s->gender ) ?></td>
                <td><?= $s->lifespan ?> ans</td>
                <td><?= $s->is_dead ? 'Oui' : 'Non' ?></td>
                <td>
                    <a href="index.php?page=edit&id=<?= $s->id ?>" class="btn btn-warning">Modifier</a>
                    <form action="index.php?page=delete&id=<?= $s->id ?>" method="post">
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Supprimer ce serpent ?');">Supprimer
                        </button>
                    </form>
					<?php if( !$s->is_dead ): ?>
                        <a class="btn btn-success" href="index.php?page=breed&id=<?= $s->id ?>">
                            Accoupler
                        </a>
					<?php endif; ?>
                </td>
                <td class="text-center">
                    <a class="btn btn-primary" href="index.php?page=genealogy&id=<?= $s->id ?>">
                        Detail
                    </a>
                </td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="Pagination" class="my-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $side <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $side > 1 ? '?' . http_build_query( [
						'page' => 'list',
						'side' => $side - 1
					] ) : '#' ?>">Précédent</a>
            </li>
			
			<?php foreach( range( 1, $totalPages ) as $page ): ?>
                <li class="page-item <?= $side == $page ? 'active' : '' ?>" <?= $side == $page ? 'aria-current="page"' : '' ?>>
                    <a class="page-link" href="<?= '?' . http_build_query( [
						'page' => 'list',
						'side' => $page
					] ) ?>"><?= $page ?></a>
                </li>
			<?php endforeach; ?>


            <li class="page-item <?= $side >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $side < $totalPages ? '?' . http_build_query( [
						'page' => 'list',
						'side' => $side + 1
					] ) : '#' ?>">Suivant</a>
            </li>
        </ul>
    </nav>
</div>
