<?php
function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<h1><?= h($title ?? 'Locatie') ?></h1>

<p>
    <a href="/customers/view/<?= h($item['customer_id'] ?? ($_GET['customer_id'] ?? '')) ?>">
        ← Terug naar klant
    </a>
</p>

<form method="POST">
    <?php foreach ($fields as $name => $props): ?>
        <?php
            $type = $props['type'] ?? 'text';
            $label = $props['label'] ?? $name;

            // value bepalen (met default fallback)
            $value = $item[$name] ?? ($props['default'] ?? '');

            // Hidden fields
            if ($type === 'hidden'):
        ?>
            <input type="hidden" name="<?= h($name) ?>" value="<?= h($value) ?>">
            <?php continue; ?>
        <?php endif; ?>

        <div style="margin-bottom: 12px;">
            <label style="display:block; font-weight:600; margin-bottom:6px;">
                <?= h($label) ?>
                <?php if (!empty($props['required'])): ?>
                    <span style="color:#c00;">*</span>
                <?php endif; ?>
            </label>

            <?php if ($type === 'textarea'): ?>
                <textarea
                    name="<?= h($name) ?>"
                    rows="4"
                    style="width: 100%; max-width: 520px;"
                    <?= !empty($props['required']) ? 'required' : '' ?>
                ><?= h($value) ?></textarea>

            <?php elseif ($type === 'checkbox'): ?>
                <?php
                    // Checkbox: als item leeg is, pak default (vaak 0/1)
                    $checked = false;
                    if (array_key_exists($name, $item)) {
                        $checked = !empty($item[$name]);
                    } else {
                        $checked = !empty($props['default']);
                    }
                ?>
                <input type="checkbox"
                       name="<?= h($name) ?>"
                       value="1"
                       <?= $checked ? 'checked' : '' ?>>

            <?php else: ?>
                <input
                    type="<?= h($type) ?>"
                    name="<?= h($name) ?>"
                    value="<?= h($value) ?>"
                    style="width: 100%; max-width: 520px;"
                    <?= !empty($props['required']) ? 'required' : '' ?>
                >
            <?php endif; ?>

            <?php if (!empty($props['help'])): ?>
                <small style="display:block; color:#666; margin-top:6px;">
                    <?= h($props['help']) ?>
                </small>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <button type="submit">Opslaan</button>
</form>