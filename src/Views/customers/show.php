<h1><?= htmlspecialchars($customer['company_name']) ?></h1>

 <?php foreach($fields as $name => $props): ?>
    <p><?= htmlspecialchars($props['label']) ?>: <?= htmlspecialchars($customer[$name]) ?></p>
<?php endforeach; ?>
<p><a href="/customers/edit/<?= $customer['id'] ?>?backpage=view">Bewerken</a></p>


<hr>

<h2>Locaties</h2>

<a href="/locations/create?customer_id=<?= $customer['id'] ?>">
    + Nieuwe locatie
</a>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <?php foreach($fields_location as $name => $props): ?>
                <?php if(!empty($props['list'])): ?>
                    <th><?= $props['label'] ?></th>
                <?php endif; ?>
            <?php endforeach; ?>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($locations as $location): ?>
        <tr>
            <?php foreach($fields_location as $name => $props): ?>
                <?php if(!empty($props['list'])): ?>
                    <td><?= htmlspecialchars($location[$name]) ?></td>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <td>
                <a href="/locations/view/<?= $location['id'] ?>">Bekijk</a>
                <a href="/locations/edit/<?= $location['id'] ?>">Bewerk</a>
                <a href="/locations/delete/<?= $location['id'] ?>">Verwijder</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>