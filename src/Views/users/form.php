<?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post">
    <?php foreach($fields as $name => $props): ?>
        <div class="form-group">
            <label for="<?= $name ?>"><?= $props['label'] ?></label>
            <?php if($props['type'] === 'checkbox'): ?>
                <input type="checkbox" name="<?= $name ?>" id="<?= $name ?>" value="1" <?= ($item[$name] ?? $props['default']) ? 'checked' : '' ?>>
            <?php elseif($props['type'] === 'password'): ?>
                <input type="password" name="<?= $name ?>" id="<?= $name ?>" placeholder="<?= isset($item['id']) ? 'Laat leeg om te behouden' : '' ?>">
            <?php else: ?>
                <input type="<?= $props['type'] ?>" name="<?= $name ?>" id="<?= $name ?>" value="<?= htmlspecialchars($item[$name] ?? $props['default']) ?>" <?= ($props['required'] ?? false) ? 'required' : '' ?>>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <button type="submit">Opslaan</button>
</form>