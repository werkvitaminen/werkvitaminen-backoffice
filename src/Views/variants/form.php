<?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">

    <?php foreach($fields as $name => $props): ?>

        <?php if(($props['type'] ?? '') === 'hidden'): ?>
            <input type="hidden"
                   name="<?= $name ?>"
                   value="<?= htmlspecialchars($item[$name] ?? $props['default'] ?? '') ?>">
            <?php continue; ?>
        <?php endif; ?>

        <div class="form-group">

            <label for="<?= $name ?>">
                <?= htmlspecialchars($props['label'] ?? $name) ?>
            </label>

            <?php if(($props['type'] ?? '') === 'checkbox'): ?>

                <input type="checkbox"
                       name="<?= $name ?>"
                       id="<?= $name ?>"
                       value="1"
                       <?= (!empty($item[$name]) || (!isset($item[$name]) && !empty($props['default']))) ? 'checked' : '' ?>>

            <?php else: ?>

                <input type="<?= htmlspecialchars($props['type'] ?? 'text') ?>"
                       name="<?= $name ?>"
                       id="<?= $name ?>"
                       value="<?= htmlspecialchars($item[$name] ?? $props['default'] ?? '') ?>"
                       <?= !empty($props['required']) ? 'required' : '' ?>>

            <?php endif; ?>

        </div>

    <?php endforeach; ?>

    <button type="submit">Opslaan</button>

</form>