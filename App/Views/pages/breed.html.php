<?php
	
	use App\Class\Managers\SnakeManager;
	use App\Class\Ecosystem;
	
	$manager = new SnakeManager();
	$snakes = $manager->getAll();
	
	$selectedId = $_GET['id'] ?? null;
	try {
		$selectedSnake = $selectedId ? $manager->getById( $selectedId ) : null;
	} catch( DateMalformedStringException $e ) {
		echo $e->getMessage();
	}
	
	$message = '';
	
	if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
		try {
			$male = $manager->getById( $_POST['male_id'] );
		} catch( DateMalformedStringException $e ) {
			echo $e->getMessage();
		}
		try {
			$female = $manager->getById( $_POST['female_id'] );
		} catch( DateMalformedStringException $e ) {
			echo $e->getMessage();
		}
		
		if( $male && $female ) {
			try {
				$baby = Ecosystem::breed( $male, $female );
			} catch( DateMalformedStringException $e ) {
				echo $e->getMessage();
			}
			if( $baby ) {
				$manager->add( $baby );
				$message = "Un nouveau bébé serpent est né : <strong>$baby->name</strong> !";
				header( 'Location: index.php?page=list' );
			} else {
				$message = "L'accouplement a échoué. Vérifie la compatibilité.";
			}
		}
	}
?>

<div class="container">
    <h1>Accouplement de serpents</h1>
	
	<?php if( $message ): ?>
        <p><strong><?= $message ?></strong></p>
	<?php endif; ?>

    <form method="POST">
        <label for="male_id">Mâle :</label>
        <select name="male_id" id="male_id" required>
			<?php foreach( $snakes as $s ): ?>
				<?php if( $s->gender === 'Male' && !$s->is_dead ): ?>
                    <option value="<?= $s->id ?>"
						<?= ( $selectedSnake && $selectedSnake->gender === 'Male' && $selectedSnake->id == $s->id ) ? 'selected' : '' ?>>
						<?= htmlspecialchars( $s->name ) ?> (<?= $s->breed ?>)
                    </option>
				<?php endif; ?>
			<?php endforeach; ?>
        </select><br><br>

        <label for="female_id">Femelle :</label>
        <select name="female_id" id="female_id" required>
			<?php foreach( $snakes as $s ): ?>
				<?php if( $s->gender === 'female' && !$s->is_dead ): ?>
                    <option value="<?= $s->id ?>"
						<?= ( $selectedSnake && $selectedSnake->gender === 'female' && $selectedSnake->id == $s->id ) ? 'selected' : '' ?>>
						<?= htmlspecialchars( $s->name ) ?> (<?= $s->breed ?>)
                    </option>
				<?php endif; ?>
			<?php endforeach; ?>
        </select><br><br>

        <button type="submit">Accoupler</button>
    </form>

    <br>
    <a href="index.php?page=list">Retour à la liste des serpents</a>
</div>
