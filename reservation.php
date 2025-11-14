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
        body{margin:0;font-family: ui-serif, "Playfair Display", Georgia, serif; background:#f8f5f7; color:#1a1a1a}
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
        a.back{display:inline-block;margin:12px 0 24px;text-decoration:none;color:#8a7a54}
        @media (max-width:768px){.row,.row-3{grid-template-columns:1fr}}
    </style>
</head>
<body>
    <div class="wrap">
        <a class="back" href="index.php"><i class="fas fa-arrow-left"></i> Retour</a>
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
