<?php
	
	$zoo = $result['data']['zoo'] ?? null;
	$isEdit = $zoo !== null && $zoo->get( 'id' ) !== null;
	$actionUrl = $isEdit
		? "index.php?ctrl=zoo&action=save&id=" . $zoo->get( 'id' )
		: "index.php?ctrl=zoo&action=save";
	$title = $isEdit
		? "Editer Le Serpent " . htmlspecialchars( $zoo->get( 'nom' ) )
		: "Ajouter un nouveau Serpent";
?>

<div class="container">
    <div class="card shadow-sm p-4 bg-white rounded">
        <h2 class="card-title text-center mb-4"><?= $title ?></h2>
        <form method="POST" action="<?= htmlspecialchars( $actionUrl ) ?>">
            <div class="form-group">
                <label for="nom">Nom du Serpent</label>
                <input
                        type="text"
                        class="form-control"
                        id="nom"
                        name="nom"
                        value="<?= $isEdit ? htmlspecialchars( $zoo->get( 'nom' ) ) : '' ?>"
                        required
                >
            </div>
            <div class="form-group my-3">
                <label for="poids">Ajouter un poids à ce serpent(en gramme)</label>
                <input
                        type="number"
                        class="form-control"
                        id="poids"
                        name="poids"
                        value="<?= $isEdit ? htmlspecialchars( $zoo->get( 'poids' ) ) : '' ?>"
                        required
                >
            </div>
            <div class="form-group my-3">
                <label for="lifestamp">Ajouter une durée de vie</label>
                <input
                        type="number"
                        class="form-control"
                        id="lifestamp"
                        name="lifestamp"
                        value="<?= $isEdit ? htmlspecialchars( $zoo->get( 'lifestamp' ) ) : '' ?>"
                        required
                >
            </div>
            <div class="form-group my-3">
                <label for="birthdate">Ajouter une date de naissance</label>
                <input
                        type="date"
                        class="form-control"
                        id="birthdate"
                        name="birthdate"
                        value="<?= $isEdit ? htmlspecialchars( $zoo->getBirthDate() ) : '' ?>"
                        required
                >
            </div>
            <div class="form-group my-3">
                <label for="birthhoure">Ajouter une heure de naissance</label>
                <input
                        type="time"
                        class="form-control"
                        id="birthhoure"
                        name="birthhoure"
                        value="<?= $isEdit ? htmlspecialchars( $zoo->getBirthHoure() ) : '' ?>"
                        required
                >
            </div>
            <div class="form-group my-3">
                <label for="race">Ajouter une race</label>
                <input
                        type="text"
                        class="form-control"
                        id="race"
                        name="race"
                        value="<?= $isEdit ? htmlspecialchars( $zoo->get( 'race' ) ) : '' ?>"
                        required
                >
            </div>
            <div class="form-group my-3">
                <div class="form-group my-3">
                    <label for="genre">Ajouter un genre</label>
                    <select
                            class="form-control"
                            id="genre"
                            name="genre"
                            required
                    >
						<?php
							
							use App\Model\Enum\GenreSerpent;
							
							$genres = GenreSerpent::cases(); // Retourne toutes les valeurs possibles
							$selectedGenre = $isEdit ? $zoo->get( 'genre' ) : ''; // Genre sélectionné
							
							foreach( $genres as $genre ) {
								$isSelected = $selectedGenre === $genre->value ? 'selected' : '';
								echo '<option value="' . htmlspecialchars( $genre->value ) . '" ' . $isSelected . '>' . htmlspecialchars( $genre->value ) . '</option>';
							}
						?>
                    </select>
                </div>

            </div>
            <button type="submit" class="btn btn-primary my-3 btn-block">Enregistrer</button>
        </form>
    </div>
</div>
