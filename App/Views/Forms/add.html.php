<?php
	
	use App\Class\Entities\Snake;
	use App\Class\Managers\SnakeManager;
	
	if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
		$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$weight = filter_input( INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_FLOAT );
		$lifespan = filter_input( INPUT_POST, 'lifespan', FILTER_SANITIZE_NUMBER_INT );
		$birthday = filter_input( INPUT_POST, 'birth_date' );
		$breed = filter_input( INPUT_POST, 'breed', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$gender = filter_input( INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$data = [
			'name' => $name,
			'weight' => $weight,
			'lifespan' => $lifespan,
			'birth_date' => $birthday,
			'breed' => $breed,
			'gender' => $gender,
			'father_id' => $_POST['father_id'] ?? null,
			'mother_id' => $_POST['mother_id'] ?? null,
			'is_dead' => false
		];
		$manager = new SnakeManager();
		try {
			$manager->add( new Snake( $data ) );
		} catch( DateMalformedStringException $e ) {
			echo $e->getMessage();
		}
		header( "Location: index.php?page=list" );
		exit;
	}
?>
<h1 class="text-center mb-3">Ajout d'un nouveau serpent</h1>
<div class="d-flex justify-content-center align-items-center">
    <form method="POST" class="formulaire w-100 max-w-50">
        <div class="my-3">
            <label for="name" class="form-label">Nom :</label>
            <input name="name" id="name" class="form-control" required/>
        </div>
        <div class="my-3">
            <label for="weight" class="form-label">Poids (kg) :</label>
            <input name="weight" id="weight" type="number" step="0.1" class="form-control" required/>
        </div>
        <div class="my-3">

            <label for="lifespan" class="form-label">Durée de vie (années) :</label>
            <input name="lifespan" id="lifespan" type="number" class="form-control" required/>
        </div>
        <div class="my-3">
            <label for="birth_date" class="form-label">Date de naissance :</label>
            <input name="birth_date" id="birth_date" type="datetime-local" class="form-control" required/>
        </div>
        <div class="my-3">
            <label for="breed" class="form-label">Race:</label>
            <input name="breed" id="breed" class="form-control" required/>
        </div>
        <div class="my-3">
            <label for="gender" class="form-label">Sexe :</label>
            <select name="gender" id="gender" class="form-select" required>
                <option value="male">Male</option>
                <option value="female">Femelle</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success my-3">Donner Naissance</button>
    </form>
</div>
<a href="index.php?page=list" class="btn btn-primary my-3">Retour à la liste des serpents</a>
