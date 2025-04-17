<div class="container">
    <h1 class="text-center mb-4">Liste des serpents</h1>
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
                        <option value="<?= $breed ?>" <?= isset( $breeded ) && $breeded === $breed ? 'selected' : '' ?>><?= htmlspecialchars( $breed ) ?></option>
					<?php endforeach; ?>
                </select>

                <!--<label for="min_weight">Poids Min :</label>
                <input type="number" name="min_weight" id="min_weight"
                       value="<?= htmlspecialchars( $min_weight ?? '' ) ?>">

                <label for="max_weight">Poids Max :</label>
                <input type="number" name="max_weight" id="max_weight"
                       value="<?= htmlspecialchars( $max_weight ?? '' ) ?>">

                <label for="is_dead">Statut (Mort/Vivant) :</label>
                <select name="is_dead" id="is_dead">
                    <option value="">Tous</option>
                    <?php $isDead = filter_input( INPUT_GET, 'is_dead', FILTER_VALIDATE_BOOL ) ?>
                    <option value="1" <?= isset( $isDead ) && $isDead == 1 ? 'selected' : '' ?>>Mort
                    </option>
                    <option value="0" <?= isset( $isDead ) && $isDead == 0 ? 'selected' : '' ?>>
                        Vivant
                    </option>
                </select>-->

                <button type="submit" class="btn btn-success">Filtrer</button>
            </form>
        </div>
        <div class="col">
            <form method="post" class="formulaire" action="index.php?page=list">
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
                <td><?= htmlspecialchars( $s->name ) ?></td>
                <td><?= htmlspecialchars( $s->weight ) ?> g</td>
                <td><?= htmlspecialchars( $s->breed ) ?></td>
                <td><?= htmlspecialchars( ucfirst( $s->gender ) ) ?></td>
                <td><?= htmlspecialchars( $s->lifespan ) ?> ans</td>
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

    <nav aria-label="Page navigation" class="my-4">
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
