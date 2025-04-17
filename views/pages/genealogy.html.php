<?php
	
	use Class\SnakeManager;
	
	$manager = new SnakeManager();
	try {
		// Utilisation de filter_input avec FILTER_VALIDATE_INT et FILTER_SANITIZE_FULL_SPECIAL_CHARS
		$id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );
		if( $id !== null && $id !== false ) {
			$snake = $manager->getById( $id );
		} else {
			$snake = null;
		}
	} catch( DateMalformedStringException $e ) {
		echo $e->getMessage();
	}
	
	function displayAncestor( $manager, $id, $level = 1 ) : void
	{
		if( !$id ) return;
		$snake = $manager->getById( $id );
		if( $snake ) {
			displayAncestor( $manager, $snake->father_id, $level + 1 );
			displayAncestor( $manager, $snake->mother_id, $level + 1 );
		}
	}
	
	function displayDescendants( $manager, $id, $level = 1 ) : void
	{
		$descendants = $manager->getChildren( $id );
		foreach( $descendants as $child ) {
			displayDescendants( $manager, $child->id, $level + 1 );
		}
	}
	
	function displaySiblings( $manager, $snake ) : void
	{
		if( !$snake->mother_id || !$snake->father_id ) return;
		$siblings = $manager->getSiblings( $snake->id, $snake->father_id, $snake->mother_id );
		if( count( $siblings ) > 0 ) {
			echo "<p><strong>Frères et sœurs :</strong><br>";
			foreach( $siblings as $s ) {
				echo "- $s->name ($s->breed)<br>";
			}
			echo "</p>";
		}
	}
	
	function displayUnclesAunts( $manager, $snake ) : void
	{
		$unclesAunts = $manager->getUnclesAndAunts( $snake );
		if( count( $unclesAunts ) > 0 ) {
			echo "<p><strong>Oncles et tantes :</strong><br>";
			foreach( $unclesAunts as $ua ) {
				echo "- $ua->name ($ua->breed)<br>";
			}
			echo "</p>";
		}
	}

?>

<?php if( $snake ): ?>
    <h1>Généalogie de <?= htmlspecialchars( $snake->name, ENT_QUOTES, 'UTF-8' ) ?></h1>
    <p>
        <strong>Race :</strong> <?= htmlspecialchars( $snake->breed, ENT_QUOTES, 'UTF-8' ) ?> | <strong>Sexe
            :</strong> <?= htmlspecialchars( $snake->gender, ENT_QUOTES, 'UTF-8' ) ?>
    </p>

    <h2>Parents et ancêtres</h2>
	<?php
	displayAncestor( $manager, $snake->father_id );
	displayAncestor( $manager, $snake->mother_id );
	?>

    <h2>Frères / Sœurs</h2>
	<?php displaySiblings( $manager, $snake ); ?>

    <h2>Oncles / Tantes</h2>
	<?php displayUnclesAunts( $manager, $snake ); ?>

    <h2>Descendance</h2>
	<?php displayDescendants( $manager, $snake->id ); ?>
<?php else: ?>
    <p>Serpent introuvable.</p>
<?php endif; ?>
<a href="index.php?page=list">Retour à la liste des serpents</a>
