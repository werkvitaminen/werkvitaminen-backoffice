<form method="get">
    <input type="text" name="search" placeholder="Zoeken..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button>Zoeken</button>
</form>

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
        <?php foreach($drivers as $c): ?>
            <tr>
                <?php foreach($fields as $name => $props): ?>
                    <?php if(!empty($props['list'])): ?>
                        <td><?= htmlspecialchars($c[$name]) ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td>
                    <a href="/drivers/edit/<?= $c['id'] ?>">Bewerken</a> |
                    <a href="/drivers/delete/<?= $c['id'] ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="/drivers/create">Nieuwe chauffeur toevoegen</a></p>