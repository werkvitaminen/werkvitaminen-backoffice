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

        <div class="form-group" data-field="<?= $name ?>">

            <label for="<?= $name ?>">
                <?= htmlspecialchars($props['label'] ?? $name) ?>
            </label>

            <?php if($name === 'fruit_type_id'): ?>

                <select name="fruit_type_id" id="fruit_type_id" required>

                    <option value="">-- kies fruitsoort --</option>

                    <?php foreach($fruit_types as $fruit): ?>

                        <option value="<?= $fruit['id'] ?>"
                        <?= ($item['fruit_type_id'] ?? '') == $fruit['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fruit['name']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            <?php elseif(($props['type'] ?? '') === 'select'): ?>

                <select name="<?= $name ?>" id="<?= $name ?>">

                    <?php foreach(($props['options'] ?? []) as $value => $label): ?>

                        <option value="<?= $value ?>"
                        <?= ($item[$name] ?? '') == $value ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            <?php elseif(($props['type'] ?? '') === 'checkbox'): ?>

                <input type="checkbox"
                       name="<?= $name ?>"
                       id="<?= $name ?>"
                       value="1"
                       <?= (!empty($item[$name]) || (!isset($item[$name]) && !empty($props['default']))) ? 'checked' : '' ?>>

            <?php elseif(($props['type'] ?? '') === 'number'): ?>

                <input type="number"
                       name="<?= $name ?>"
                       step="0.001"
                       min="0"
                       id="<?= $name ?>"
                       value="<?= htmlspecialchars($item[$name] ?? $props['default'] ?? '') ?>"
                       <?= ($props['required'] ?? false) ? 'required' : '' ?>>

            <?php else: ?>

                <input type="<?= htmlspecialchars($props['type'] ?? 'text') ?>"
                       name="<?= $name ?>"
                       id="<?= $name ?>"
                       value="<?= htmlspecialchars($item[$name] ?? $props['default'] ?? '') ?>"
                       <?= ($props['required'] ?? false) ? 'required' : '' ?>>

            <?php endif; ?>

        </div>

    <?php endforeach; ?>

    <button type="submit">Opslaan</button>

</form>

<script>

function toggleFields() {

    const type = document.getElementById('type')?.value;

    const ratio = document.querySelector('[data-field="ratio_value"]');
    const per_x_pieces = document.querySelector('[data-field="per_x_pieces"]');
    const qty = document.querySelector('[data-field="quantity"]');

    if(type === 'ratio'){

        ratio.style.display = 'block';
        per_x_pieces.style.display = 'none';
        qty.style.display = 'none';

    } else {

        ratio.style.display = 'none';
        per_x_pieces.style.display = 'block';
        qty.style.display = 'block';

    }
}

document.getElementById('type')?.addEventListener('change', toggleFields);

toggleFields();

</script>