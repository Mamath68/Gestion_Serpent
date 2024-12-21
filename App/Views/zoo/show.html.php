<div class="container">
    <div class="card shadow-sm">
        <div class="card-body text-center">
			<?php if( isset( $result['data']['zoo'] ) ) :
				$card = $result['data']['zoo']; ?>
                <h1 class="card-title display-4 mb-4"><?= $card->get( "nom" ) ?></h1>
                <ul class="list-unstyled">
                    <li class="mb-3">Poids : <span class="font-weight-bold"><?= $card->get( "poids" ) ?> G</span></li>
                    <li class="mb-3">Durée de Vie: <span
                                class="font-weight-bold"><?= $card->get( "lifestamp" ) ?> ans</span></li>
                    <li class="mb-3">Date et heure de Naissance : <span class="font-weight-bold"><?= $card->getBirthDate() ?></span></li><li class="mb-3">Date et heure de Naissance : <span class="font-weight-bold"><?= $card->getBirthHoure() ?></span></li>
                    <li class="mb-3">Race : <span class="font-weight-bold"><?= $card->get("race") ?></span></li>
                    <li class="mb-3">Genre : <span class="font-weight-bold"><?= $card->get("genre") ?></span></li>
                </ul>

                <a href="index.php?ctrl=zoo&action=form&id=<?= $card->get( 'id' ) ?>">Update</a>
			<?php else: ?>
                <h2 class="text-danger">No Cards Found</h2>
			<?php endif; ?>
        </div>
    </div>
</div>
