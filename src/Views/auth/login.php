<style>
    .login-wrapper {
        max-width: 400px;
        margin: 80px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    label { display:block; margin-top:10px; }
    input { width:100%; padding:8px; margin-top:5px; }
    button { margin-top:15px; width:100%; padding:10px; background:#333; color:#fff; border:none; cursor:pointer; }
    button:hover { background:#555; }
    .error { color:red; margin-top:10px; }
</style>

<div class="login-wrapper">
    <h1>Inloggen</h1>

    <?php if(!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="email">E-mail</label>
        <input type="email" name="email" required>

        <label for="password">Wachtwoord</label>
        <input type="password" name="password" required>

        <button type="submit">Inloggen</button>
    </form>
</div>