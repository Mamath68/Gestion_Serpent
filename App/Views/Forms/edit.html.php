<h1 class="text-center mb-3">Modifier le serpent : <?= $snake->name ?></h1>

<div class="d-flex justify-content-center align-items-center">
    <form method="POST" class="formulaire w-100 max-w-50">
        <div class="my-3">
            <label for="name" class="form-label">Nom :</label>
            <input name="name" id="name" value="<?= $snake->name ?>" class="form-control" required/>
        </div>
        <div class="my-3">
            <label for="weight" class="form-label">Poids (kg) :</label>
            <input name="weight" id="weight" type="number" step="0.1" value="<?= $snake->weight ?>" class="form-control"
                   required/>
        </div>
        <div class="my-3">
            <label for="lifespan" class="form-label">Durée de vie (années) :</label>
            <input name="lifespan" id="lifespan" type="number" value="<?= $snake->lifespan ?>" class="form-control"
                   required/>
        </div>
        <div class="my-3">
            <label for="birth_date" class="form-label">Date de naissance :</label>
            <input name="birth_date" id="birth_date" type="datetime-local"
                   value="<?= date( 'Y-m-d\TH:i', strtotime( $snake->birth_date ) ) ?>" class="form-control" required/>
        </div>
        <div class="my-3">
            <label for="breed" class="form-label">Race:</label>
            <input name="breed" id="breed" value="<?= $snake->breed ?>" class="form-control" required/>
        </div>
        <div class="my-3">
            <label for="gender" class="form-label">Sexe :</label>
            <select name="gender" id="gender" class="form-select">
                <option value="Male" <?= $snake->gender === 'Male' ? 'selected' : '' ?>>Mâle</option>
                <option value="Femelle" <?= $snake->gender === 'Femelle' ? 'selected' : '' ?>>Femelle</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
<a href="index.php?page=list" class="btn btn-secondary">Retourner à la liste des serpents</a>
