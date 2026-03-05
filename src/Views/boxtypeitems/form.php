<?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">

    <?php foreach($fields as $name => $props): ?>

        <div class="form-group">

            <label for="<?= $name ?>"><?= $props['label'] ?></label>

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

            <?php elseif($props['type'] === 'number'): ?>

                <input type="number"
                       name="<?= $name ?>"
                       step="0.01"
                       min="0"
                       id="<?= $name ?>"
                       value="<?= htmlspecialchars($item[$name] ?? $props['default']) ?>"
                       <?= ($props['required'] ?? false) ? 'required' : '' ?>>

            <?php else: ?>

                <input type="<?= $props['type'] ?>"
                       name="<?= $name ?>"
                       id="<?= $name ?>"
                       value="<?= htmlspecialchars($item[$name] ?? $props['default']) ?>"
                       <?= ($props['required'] ?? false) ? 'required' : '' ?>>

            <?php endif; ?>

        </div>

    <?php endforeach; ?>

    <button type="submit">Opslaan</button>

</form>