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