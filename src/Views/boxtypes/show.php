<h1><?= htmlspecialchars($item['name']) ?></h1>

<?php foreach ($fields as $name => $props): ?>
    <p>
        <?= htmlspecialchars($props['label']) ?>:
        <?= htmlspecialchars($item[$name]) ?>
    </p>
<?php endforeach; ?>

<p>
    <a href="/boxtypes/edit/<?= $item['id'] ?>?backpage=view">
        Bewerken
    </a>
</p>

<h2>Fruitsoorten in deze box</h2>

<a href="/boxtypeitems/create?box_type_id=<?= $item['id'] ?>">
    + Fruitsoort toevoegen
</a>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <?php foreach($fields_items as $name => $props): ?>
                <?php if(!empty($props['list'])): ?>
                    <th><?= $props['label'] ?></th>
                <?php endif; ?>
            <?php endforeach; ?>
            <th>Acties</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($items as $i): ?>
        <tr>

            <?php foreach($fields_items as $name => $props): ?>
                <?php if(!empty($props['list'])): ?>

                    <?php if($name === 'fruit_type_id'): ?>
                        <td><?= htmlspecialchars($i['fruit_name']) ?></td>
                    <?php else: ?>
                        <td><?= htmlspecialchars($i[$name]) ?></td>
                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>

            <td>
              
                <a href="/boxtypeitems/edit/<?= $i['id'] ?>">Bewerk</a>
                <a href="/boxtypeitems/delete/<?= $i['id'] ?>">Verwijder</a>
            
            </td>

        </tr>
        <?php endforeach; ?>

    </tbody>
</table>