<h1><?= htmlspecialchars($title) ?></h1>

<a href="/boxtypes/create">+ Nieuw fruitbox type</a>

<?php if (!empty($_SESSION['error'])): ?>
    <div style="color:red;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <?php foreach ($fields as $name => $props): ?>
                <?php if (!empty($props['list'])): ?>
                    <th><?= htmlspecialchars($props['label']) ?></th>
                <?php endif; ?>
            <?php endforeach; ?>
            <th>Acties</th>
        </tr>
    </thead>    

    <tbody>

        <?php foreach ($items as $item): ?>
            <tr>

                <?php foreach ($fields as $name => $props): ?>
                    <?php if (!empty($props['list'])): ?>
                        <td><?= htmlspecialchars($item[$name]) ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>

                <td>
                    <a href="/boxtypes/view/<?= $item['id'] ?>">Bekijken</a>
                    <a href="/boxtypes/edit/<?= $item['id'] ?>">Bewerk</a>
                    <a href="/boxtypes/delete/<?= $item['id'] ?>">Verwijder</a>
                </td>

            </tr>
        <?php endforeach; ?>

    </tbody>
</table>