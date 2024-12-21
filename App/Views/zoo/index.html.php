<?php global $result, $title; ?>

<div class="container text-center mt-5">
    <div class="card shadow-sm p-3 mb-5 bg-white rounded">
        <h1 class="card-title"><?= $title ?></h1>
        <div class="card-body">
			<?php if( isset( $result['data']['serpents'] ) ): ?>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Poids(grame)</th>
                        <th scope="col">Durée de vie</th>
                        <th scope="col">Date de naissance</th>
                        <th scope="col">Heure de naissance</th>
                        <th scope="col">Race</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach( $result['data']['serpents'] as $snake ): ?>
                        <tr>
                            <td><?= $snake->get( "nom" ) ?></td>
                            <td><?= $snake->get( "poids" ) ?></td>
                            <td><?= $snake->get( "lifestamp" ) ?></td>
                            <td><?= $snake->getBirthDate() ?></td>
                            <td><?= $snake->getBirthHoure() ?></td>
                            <td><?= $snake->get( "race" ) ?></td>
                            <td><?= $snake->get( "genre" ) ?></td>
                            <td>
                                <a href="index.php?ctrl=zoo&action=show&id=<?= $snake->get( 'id' ) ?>"
                                   class="btn btn-info btn-sm">Voir</a>
                                <a href="index.php?ctrl=zoo&action=form&id=<?= $snake->get( 'id' ) ?>"
                                   class="btn btn-warning btn-sm">Modifier</a>
                            </td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
			<?php else: ?>
                <h2 class="text-danger">Aucune serpents trouvée</h2>
			<?php endif; ?>
        </div>
    </div>
    <a href="index.php?ctrl=zoo&action=form" class="btn btn-primary my-3">Ajouter un serpent</a>
</div>
