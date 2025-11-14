<?php
declare(strict_types=1);
require __DIR__ . '/config/db.php';

$statuses = ['pending','confirmed','cancelled'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'update_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'pending';
        if ($id > 0 && in_array($status, $statuses, true)) {
            $stmt = $pdo->prepare('UPDATE reservations SET status=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([$status, $id]);
        }
        header('Location: admin.php');
        exit;
    }
}

$where = [];
$params = [];
$filter_status = $_GET['status'] ?? '';
if ($filter_status && in_array($filter_status, $statuses, true)) {
    $where[] = 'status = ?';
    $params[] = $filter_status;
}
$filter_date = $_GET['date'] ?? '';
if ($filter_date) {
    $where[] = 'date = ?';
    $params[] = $filter_date;
}

$sql = 'SELECT * FROM reservations';
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY date DESC, time DESC, created_at DESC';
$stm = $pdo->prepare($sql);
$stm->execute($params);
$reservations = $stm->fetchAll();

$cap = $pdo->query('SELECT max_guests_per_slot, slot_minutes FROM capacity_settings WHERE id=1')->fetch();
$maxPerSlot = $cap['max_guests_per_slot'] ?? 20;
$slotMinutes = (int)($cap['slot_minutes'] ?? 30);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin • Réservations</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body{font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial; margin:0; background:#f6f7fb; color:#111}
    .wrap{max-width:1100px;margin:30px auto;padding:0 16px}
    .card{background:#fff;border:1px solid #eee;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,.05);padding:18px}
    h1{margin:0 0 12px 0;font-size:22px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid #f0f0f0;text-align:left}
    th{font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:#666}
    .filters{display:flex;gap:10px;align-items:center;margin:12px 0}
    input,select{padding:8px 10px;border:1px solid #ddd;border-radius:8px}
    .status{padding:4px 8px;border-radius:8px;font-size:12px;display:inline-block}
    .s-pending{background:#fff7e6;border:1px solid #ffe2a8}
    .s-confirmed{background:#eaffea;border:1px solid #b6efb4}
    .s-cancelled{background:#ffecec;border:1px solid #f5b3b3}
    .muted{color:#666;font-size:12px}
    .row{display:flex;gap:10px;align-items:center}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card" style="margin-bottom:16px">
      <h1>Réservations</h1>
      <div class="muted">Capacité: <?php echo (int)$maxPerSlot; ?> couverts / créneau • Créneau: <?php echo (int)$slotMinutes; ?> min</div>
      <form class="filters" method="get">
        <div class="row">
          <label for="date" class="muted">Date</label>
          <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($filter_date, ENT_QUOTES, 'UTF-8'); ?>" />
        </div>
        <div class="row">
          <label for="status" class="muted">Statut</label>
          <select id="status" name="status">
            <option value="">Tous</option>
            <?php foreach ($statuses as $s): ?>
              <option value="<?php echo $s; ?>" <?php echo $filter_status===$s?'selected':''; ?>><?php echo ucfirst($s); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit">Filtrer</button>
      </form>
    </div>

    <div class="card">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Nom</th>
            <th>Personnes</th>
            <th>Contact</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$reservations): ?>
          <tr><td colspan="8" class="muted">Aucune réservation</td></tr>
        <?php else: ?>
          <?php foreach ($reservations as $r): ?>
            <tr>
              <td><?php echo (int)$r['id']; ?></td>
              <td><?php echo htmlspecialchars($r['date'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars(substr($r['time'],0,5), ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($r['name'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo (int)$r['guests']; ?></td>
              <td>
                <div class="muted">Email: <?php echo htmlspecialchars($r['email'], ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="muted">Tel: <?php echo htmlspecialchars($r['phone'], ENT_QUOTES, 'UTF-8'); ?></div>
              </td>
              <td>
                <span class="status s-<?php echo htmlspecialchars($r['status'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo ucfirst($r['status']); ?></span>
              </td>
              <td>
                <form method="post" class="row">
                  <input type="hidden" name="action" value="update_status" />
                  <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>" />
                  <select name="status">
                    <?php foreach ($statuses as $s): ?>
                      <option value="<?php echo $s; ?>" <?php echo $r['status']===$s?'selected':''; ?>><?php echo ucfirst($s); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <button type="submit">OK</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
