<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Werkvitaminen Backoffice' ?></title>
    <style>
        body { display: flex; font-family: Arial, sans-serif; margin:0; }
        .sidebar { width: 200px; background: #f0f0f0; padding: 20px; height: 100vh; }
        .sidebar a { display: block; margin-bottom: 10px; color: #333; text-decoration: none; }
        .sidebar a:hover { text-decoration: underline; }
        .content { flex: 1; padding: 20px; }
        h1 { margin-top: 0; }
    </style>
</head>
<body>
    <div class="sidebar">
        
        <?php if(\App\Core\Auth::user()): ?>
            <h2>Operatie</h2>
            <a href="/">Dashboard</a>
            <a href="/customers">Klanten</a> 
            <a href="#">Inkoop</a> 
            <a href="#">Leveringen</a> 
            <a href="#">Routes</a> 
            <a href="#">Actuele samenstelling</a> 
            <br /><br />
            <h2>Marketing</h2>
            <a href="#">Dashboard</a>
            <a href="#">Leads</a>  
            <a href="#">Proefpakketten</a>    
            <br /><br />
            <h2>Configuratie</h2>
            
            <a href="/users">Gebruikers</a>
            <a href="/drivers">Chauffeurs</a>
            <a href="/fruittypes">Fruitsoorten</a>
            <a href="/boxtypes">Type fruitboxen</a>
            <br /><br />
            <a href="/logout">Uitloggen</a>

        <?php else: ?>
            <h2>Menu</h2>
            <a href="/login">Inloggen</a>
        <?php endif; ?>
    </div>
    <div class="content">
        <?= $content ?? '' ?>
    </div>
</body>
</html>