<?php
declare(strict_types=1);

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');
    $guests = (int)($_POST['guests'] ?? 0);
    $notes = trim($_POST['notes'] ?? '');

    if ($name === '') $errors[] = 'Nom requis';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide';
    if ($phone === '') $errors[] = 'Téléphone requis';
    if ($date === '') $errors[] = 'Date requise';
    if ($time === '') $errors[] = 'Heure requise';
    if ($guests < 1) $errors[] = 'Nombre de personnes invalide';

    if (!$errors) {
        require __DIR__ . '/config/db.php';

        $settings = $pdo->query('SELECT max_guests_per_slot, slot_minutes FROM capacity_settings WHERE id=1')->fetch();
        $maxPerSlot = $settings['max_guests_per_slot'] ?? 20;
        $slotMinutes = (int)($settings['slot_minutes'] ?? 30);

        $ts = strtotime($time ?: '00:00');
        $slotSeconds = max(1, $slotMinutes) * 60;
        $slotTs = (int)(floor($ts / $slotSeconds) * $slotSeconds);
        $slotTime = date('H:i:s', $slotTs);

        $ov = $pdo->prepare('SELECT max_guests FROM capacity_overrides WHERE date=? AND time=?');
        $ov->execute([$date, $slotTime]);
        $override = $ov->fetch();
        if ($override && isset($override['max_guests'])) {
            $maxPerSlot = (int)$override['max_guests'];
        }

        $q = $pdo->prepare("SELECT COALESCE(SUM(guests),0) AS current FROM reservations WHERE date=? AND time=? AND status IN ('pending','confirmed')");
        $q->execute([$date, $slotTime]);
        $current = (int)($q->fetch()['current'] ?? 0);

        if ($current + $guests > $maxPerSlot) {
            $errors[] = "Désolé, ce créneau est complet. Veuillez choisir un autre horaire.";
        } else {
            $stmt = $pdo->prepare('INSERT INTO reservations (name, email, phone, date, time, guests, notes, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
            $stmt->execute([$name, $email, $phone, $date, $slotTime, $guests, $notes]);
            $success = true;
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Réservation • Keyfet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root{--gold:#d4af37;--bg:#f8f5f7;--text:#1a1a1a;--muted:#666;}
        body{margin:0;font-family: ui-serif, "Playfair Display", Georgia, serif; background:var(--bg); color:var(--text)}
        .site-header{position:sticky;top:0;z-index:100;background:rgba(255,255,255,0.9);backdrop-filter:blur(12px);border-bottom:1px solid rgba(0,0,0,0.05)}
        .header-inner{display:flex;align-items:center;justify-content:space-between;padding:16px 24px;max-width:1200px;margin:0 auto}
        .brand{font-family:'Playfair Display',serif;font-size:24px;font-weight:600;color:var(--text);text-decoration:none;letter-spacing:0.08em;text-transform:uppercase}
        .main-nav{display:flex;gap:20px;align-items:center}
        .main-nav a{font-size:15px;letter-spacing:0.08em;text-transform:uppercase;text-decoration:none;color:var(--text);position:relative;padding-bottom:6px}
        .main-nav a::after{content:'';position:absolute;left:0;bottom:0;width:100%;height:2px;background:linear-gradient(135deg,var(--gold) 0%,#f1c14d 100%);opacity:0;transform:scaleX(0);transform-origin:center;transition:transform .25s ease,opacity .25s ease}
        .main-nav a:hover::after,.main-nav a.active::after{opacity:1;transform:scaleX(1)}
        .social-nav{display:flex;gap:12px;color:#8a7a54}
        .social-nav a{color:#8a7a54;font-size:14px;transition:color .2s ease}
        .social-nav a:hover{color:var(--gold)}
        @media (max-width:720px){.header-inner{flex-direction:column;gap:12px}.main-nav{flex-wrap:wrap;justify-content:center}}
        .wrap{max-width:900px;margin:40px auto;padding:0 16px}
        h1{font-family:'Playfair Display',serif;font-weight:500}
        .card{background:#fff;border:1px solid #eee;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,.06);padding:24px}
        .row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .row-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
        label{display:block;font-size:14px;margin:8px 0 6px}
        input,select,textarea{width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:10px;font-family:inherit}
        textarea{min-height:100px}
        .btn{display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#d4af37 0%,#f1c14d 100%);color:#fff;border:none;border-radius:50px;padding:14px 26px;font-weight:600;cursor:pointer;box-shadow:0 10px 25px rgba(212,175,55,.3)}
        .note{font-size:14px;color:#666;margin-top:8px}
        .alert{padding:12px 16px;border-radius:8px;margin-bottom:16px}
        .alert-error{background:#fee;border:1px solid #fbb;color:#900}
        .alert-ok{background:#eefbea;border:1px solid #b6efb4;color:#165c1b}
        @media (max-width:768px){.row,.row-3{grid-template-columns:1fr}}
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="index.php">Keyfet</a>
            <nav class="main-nav">
                <a href="index.php">Accueil</a>
                <a href="carte.php">Carte</a>
                <a href="restaurant.php">Nos restaurants</a>
                <a href="reservation.php" class="active">Réserver</a>
            </nav>
            <div class="social-nav">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </header>
    <div class="wrap">
        <h1>Réservation</h1>
        <?php if ($success): ?>
            <div class="alert alert-ok">Votre réservation a été enregistrée.</div>
        <?php endif; ?>
        <?php if ($errors): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $e): ?>
                    <div>• <?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="card">
            <form method="post">
                <div class="row">
                    <div>
                        <label for="name">Nom complet</label>
                        <input id="name" name="name" type="text" required value="<?php echo isset($name)?htmlspecialchars($name,ENT_QUOTES,'UTF-8'):''; ?>">
                    </div>
                    <div class="row">
                        <div>
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" required value="<?php echo isset($email)?htmlspecialchars($email,ENT_QUOTES,'UTF-8'):''; ?>">
                        </div>
                        <div>
                            <label for="phone">Téléphone</label>
                            <input id="phone" name="phone" type="tel" required value="<?php echo isset($phone)?htmlspecialchars($phone,ENT_QUOTES,'UTF-8'):''; ?>">
                        </div>
                    </div>
                </div>
                <div class="row-3" style="margin-top:16px">
                    <div>
                        <label for="date">Date</label>
                        <input id="date" name="date" type="date" required value="<?php echo isset($date)?htmlspecialchars($date,ENT_QUOTES,'UTF-8'):''; ?>">
                    </div>
                    <div>
                        <label for="time">Heure</label>
                        <input id="time" name="time" type="time" required value="<?php echo isset($time)?htmlspecialchars($time,ENT_QUOTES,'UTF-8'):''; ?>">
                    </div>
                    <div>
                        <label for="guests">Personnes</label>
                        <select id="guests" name="guests" required>
                            <?php for ($i=1;$i<=12;$i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo (isset($guests) && (int)$guests===$i)?'selected':''; ?>><?php echo $i; ?><?php echo $i>1?' personnes':' personne'; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div style="margin-top:16px">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" placeholder="Allergies, préférences, occasion..."><?php echo isset($notes)?htmlspecialchars($notes,ENT_QUOTES,'UTF-8'):''; ?></textarea>
                </div>
                <div style="margin-top:20px">
                    <button class="btn" type="submit"><i class="fas fa-check"></i> Réserver</button>
                    <div class="note">Nous confirmerons votre réservation par email ou téléphone.</div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
