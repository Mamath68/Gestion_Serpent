<h1>Généalogie de <?= htmlspecialchars($snake->name) ?></h1>
<p>
    <strong>Race :</strong> <?= htmlspecialchars($snake->breed) ?> |
    <strong>Sexe :</strong> <?= htmlspecialchars($snake->gender) ?>
</p>

<h2>Parents et ancêtres</h2>
<?php if (!empty($ancestors)): ?>
    <ul>
        <?php foreach ($ancestors as $entry): ?>
            <li style="margin-left: <?= $entry['level'] * 20 ?>px;">
                <?= htmlspecialchars($entry['snake']->name) ?> (<?= htmlspecialchars($entry['snake']->breed) ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun ancêtre trouvé.</p>
<?php endif; ?>

<h2>Frères / Sœurs</h2>
<?php if (!empty($siblings)): ?>
    <ul>
        <?php foreach ($siblings as $sibling): ?>
            <li><?= htmlspecialchars($sibling->name) ?> (<?= htmlspecialchars($sibling->breed) ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Pas de frères ou sœurs connus.</p>
<?php endif; ?>

<h2>Oncles / Tantes</h2>
<?php if (!empty($unclesAunts)): ?>
    <ul>
        <?php foreach ($unclesAunts as $ua): ?>
            <li><?= htmlspecialchars($ua->name) ?> (<?= htmlspecialchars($ua->breed) ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Pas d'oncles ni de tantes connus.</p>
<?php endif; ?>

<h2>Descendance</h2>
<?php if (!empty($descendants)): ?>
    <ul>
        <?php foreach ($descendants as $entry): ?>
            <li style="margin-left: <?= $entry['level'] * 20 ?>px;">
                <?= htmlspecialchars($entry['snake']->name) ?> (<?= htmlspecialchars($entry['snake']->breed) ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucune descendance connue.</p>
<?php endif; ?>

<a href="index.php?page=list">Retour à la liste des serpents</a>
