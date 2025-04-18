<div class="container">
    <h1>Accouplement de serpents</h1>
	
	<?php if( !empty( $message ) ) : ?>
        <p><strong><?= $message ?></strong></p>
	<?php endif; ?>
    <div class="d-flex justify-content-center align-items-center">
        <form method="POST" class="formulaire w-100 max-w-50">
            <div class="my-3">
                <label for="male_id" class="form-label">Mâle :</label>
                <select name="male_id" id="male_id" class="form-select" required>
					<?php foreach( $snakes as $s ): ?>
						<?php if( $s->gender === 'Male' && !$s->is_dead ): ?>
                            <option value="<?= $s->id ?>"
								<?= ( $selectedSnake && $selectedSnake->gender === 'Male' && $selectedSnake->id == $s->id ) ? 'selected' : '' ?>>
								<?= htmlspecialchars( $s->name ) ?> (<?= $s->breed ?>)
                            </option>
						<?php endif; ?>
					<?php endforeach; ?>
                </select>
            </div>
            <div class="my-3">
                <label for="female_id" class="form-label">Femelle :</label>
                <select name="female_id" id="female_id" class="form-select" required>
					<?php foreach( $snakes as $s ): ?>
						<?php if( $s->gender === 'Femelle' && !$s->is_dead ): ?>
                            <option value="<?= $s->id ?>"
								<?= ( $selectedSnake && $selectedSnake->gender === 'Femelle' && $selectedSnake->id == $s->id ) ? 'selected' : '' ?>>
								<?= htmlspecialchars( $s->name ) ?> (<?= $s->breed ?>)
                            </option>
						<?php endif; ?>
					<?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Accoupler</button>
        </form>
    </div>

    <a href="index.php?page=list" class="btn btn-primary">Retour à la liste des serpents</a>
</div>
