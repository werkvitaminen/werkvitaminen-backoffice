<h1><?= htmlspecialchars($location['name']) ?></h1>

<p><?= htmlspecialchars($location['street']) ?> <?= htmlspecialchars($location['house_number']) ?></p>
<p><?= htmlspecialchars($location['postal_code']) ?> <?= htmlspecialchars($location['city']) ?></p>

<hr>

<h2>Fruitkisten</h2>

<a href="/fruitboxes/create?location_id=<?= $location['id'] ?>">
    + Nieuwe fruitkist
</a>

<table>
    <tr>
        <th>Naam</th>
        <th>Dag</th>
        <th>Actief</th>
        <th>Acties</th>
    </tr>

    <?php foreach ($boxes as $box): ?>
    <tr>
        <td><?= htmlspecialchars($box['name']) ?></td>
        <td><?= htmlspecialchars($box['delivery_day']) ?></td>
        <td><?= $box['active'] ? 'Ja' : 'Nee' ?></td>
        <td>
            <a href="/fruitboxes/edit/<?= $box['id'] ?>">Bewerk</a>
            <a href="/fruitboxes/delete/<?= $box['id'] ?>">Verwijder</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>