<div class="container">
    <h1 class="text-center mb-3">Généalogie de <?= htmlspecialchars( $snake->name ) ?></h1>

    <p class="lead">
        <strong>Race :</strong> <?= htmlspecialchars( $snake->breed ) ?> |
        <strong>Sexe :</strong> <?= htmlspecialchars( $snake->gender ) ?>
    </p>

    <div class="mb-5">
        <h2 class="mb-3">Parents et ancêtres</h2>
		<?php if( !empty( $ancestors ) ) : ?>
            <ul class="list-group">
				<?php foreach( $ancestors as $entry ) : ?>
                    <li class="list-group-item" style="margin-left: <?= $entry->level * 20 ?>px;">
						<?= htmlspecialchars( $entry->snake->name ) ?> <small
                                class="text-muted">(<?= htmlspecialchars( $entry->snake->breed ) ?>)</small>
                    </li>
				<?php endforeach; ?>
            </ul>
		<?php else : ?>
            <p class="text-muted">Aucun ancêtre trouvé.</p>
		<?php endif; ?>
    </div>

    <div class="mb-5">
        <h2 class="mb-3">Frères / Sœurs</h2>
		<?php if( !empty( $siblings ) ) : ?>
            <ul class="list-group">
				<?php foreach( $siblings as $sibling ) : ?>
                    <li class="list-group-item">
						<?= htmlspecialchars( $sibling->name ) ?> <small
                                class="text-muted">(<?= htmlspecialchars( $sibling->breed ) ?>)</small>
                    </li>
				<?php endforeach; ?>
            </ul>
		<?php else : ?>
            <p class="text-muted">Pas de frères ou sœurs connus.</p>
		<?php endif; ?>
    </div>

    <div class="mb-5">
        <h2 class="mb-3">Oncles / Tantes</h2>
		<?php if( !empty( $unclesAunts ) ) : ?>
            <ul class="list-group">
				<?php foreach( $unclesAunts as $ua ) : ?>
                    <li class="list-group-item">
						<?= htmlspecialchars( $ua->name ) ?> <small
                                class="text-muted">(<?= htmlspecialchars( $ua->breed ) ?>)</small>
                    </li>
				<?php endforeach; ?>
            </ul>
		<?php else : ?>
            <p class="text-muted">Pas d'oncles ni de tantes connus.</p>
		<?php endif; ?>
    </div>

    <div class="mb-5">
        <h2 class="mb-3">Descendance</h2>
		<?php if( !empty( $descendants ) ) : ?>
            <ul class="list-group">
				<?php foreach( $descendants as $entry ) : ?>
                    <li class="list-group-item" style="margin-left: <?= $entry->level * 20 ?>px;">
						<?= htmlspecialchars( $entry->snake->name ) ?> <small
                                class="text-muted">(<?= htmlspecialchars( $entry->snake->breed ) ?>
                            - <?= $entry->snake->gender ?>)</small>
                    </li>
				<?php endforeach; ?>
            </ul>
		<?php else : ?>
            <p class="text-muted">Aucune descendance connue.</p>
		<?php endif; ?>
    </div>

    <a href="index.php?page=list" class="btn btn-secondary">
        &larr; Retour à la liste des serpents
    </a>
</div>
