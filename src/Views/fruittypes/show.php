<h1><?= htmlspecialchars($item['name']) ?></h1>

 <?php foreach($fields as $name => $props): ?>
    <p><?= htmlspecialchars($props['label']) ?>: <?= htmlspecialchars($item[$name]) ?></p>
<?php endforeach; ?>
<p><a href="/fruittypes/edit/<?= $item['id'] ?>?backpage=view">Bewerken</a></p


<h2>Inkoop varianten</h2>

<a href="/variants/create?fruit_type_id=<?= $item['id'] ?>">
    + Nieuwe variant aanmaken
</a>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <?php foreach($fields_variants as $name => $props): ?>
                <?php if(!empty($props['list'])): ?>
                    <th><?= $props['label'] ?></th>
                <?php endif; ?>
            <?php endforeach; ?>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($variants as $variant): ?>
        <tr>
            <?php foreach($fields_variants as $name => $props): ?>
                <?php if(!empty($props['list'])): ?>
                    <td><?= htmlspecialchars($variant[$name]) ?></td>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <td>
                <a href="/variants/edit/<?= $variant['id'] ?>">Bewerk</a>
                <a href="/variants/delete/<?= $variant['id'] ?>">Verwijder</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>