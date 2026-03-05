<form method="get">
    <input type="text" name="search" placeholder="Zoeken..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button>Zoeken</button>
</form>

<?php if (!empty($_SESSION['error'])): ?>
    <div style="color:red;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <?php foreach($fields as $name => $props): ?>
                <?php if(!empty($props['list'])): ?>
                    <th><?= $props['label'] ?></th>
                <?php endif; ?>
            <?php endforeach; ?>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($customers as $c): ?>
            <tr>
                <?php foreach($fields as $name => $props): ?>
                    <?php if(!empty($props['list'])): ?>
                        <td><?= htmlspecialchars($c[$name]) ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td>
                    <a href="/customers/view/<?= $c['id'] ?>">Bekijken</a> |
                    <a href="/customers/edit/<?= $c['id'] ?>">Bewerken</a> |
                    <a href="/customers/delete/<?= $c['id'] ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="/customers/create">Nieuwe klant toevoegen</a></p>