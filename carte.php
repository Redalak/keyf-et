<?php
declare(strict_types=1);
require __DIR__ . '/config/db.php';

$cats = $pdo->query('SELECT id, name, description FROM menu_categories WHERE active=1 ORDER BY position ASC, id ASC')->fetchAll();
$itemsByCat = [];
if ($cats) {
    $stmt = $pdo->prepare('SELECT id, name, description, price, image_url FROM menu_items WHERE active=1 AND category_id=? ORDER BY position ASC, id ASC');
    foreach ($cats as $c) {
        $stmt->execute([$c['id']]);
        $itemsByCat[$c['id']] = $stmt->fetchAll();
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Notre Carte • Keyfet</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,300;0,400;0,500;0,600;0,700&family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">
  <style>
    :root{ --gold:#d4af37; }
    body{margin:0;background:#f8f5f7;color:#1a1a1a;font-family: ui-serif, "Playfair Display", Georgia, serif}
    .site-header{position:sticky;top:0;z-index:100;background:rgba(255,255,255,0.9);backdrop-filter:blur(12px);border-bottom:1px solid rgba(0,0,0,0.05);}
    .header-inner{display:flex;align-items:center;justify-content:space-between;padding:16px 24px;max-width:1200px;margin:0 auto}
    .brand{font-family:'Playfair Display',serif;font-size:24px;font-weight:600;color:#1a1a1a;text-decoration:none;letter-spacing:0.08em;text-transform:uppercase}
    .main-nav{display:flex;gap:20px;align-items:center}
    .main-nav a{font-size:15px;letter-spacing:0.08em;text-transform:uppercase;text-decoration:none;color:#1a1a1a;position:relative;padding-bottom:6px}
    .main-nav a::after{content:'';position:absolute;left:0;bottom:0;width:100%;height:2px;background:linear-gradient(135deg,var(--gold) 0%,#f1c14d 100%);opacity:0;transform:scaleX(0);transform-origin:center;transition:transform .25s ease,opacity .25s ease}
    .main-nav a:hover::after,.main-nav a.active::after{opacity:1;transform:scaleX(1)}
    .social-nav{display:flex;gap:12px;color:#8a7a54}
    .social-nav a{color:#8a7a54;font-size:14px;transition:color .2s ease}
    .social-nav a:hover{color:var(--gold)}
    @media (max-width:720px){
      .header-inner{flex-direction:column;gap:12px}
      .main-nav{flex-wrap:wrap;justify-content:center}
    }
    .wrap{max-width:1200px;margin:30px auto;padding:0 20px}
    a.back{display:inline-block;margin:12px 0 24px;text-decoration:none;color:#8a7a54}
    h1{font-family:'Playfair Display',serif;font-weight:500;margin:0 0 10px}
    .muted{color:#666}
    .section{margin:26px 0}
    .section h2{font-family:'Playfair Display',serif;font-weight:600;margin:0 0 12px}
    .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
    @media (max-width:1024px){ .grid{grid-template-columns:repeat(2,1fr)} }
    @media (max-width:640px){ .grid{grid-template-columns:1fr} }
    .card{background:#fff;border:1px solid #eee;border-radius:14px;overflow:hidden;box-shadow:0 10px 25px rgba(0,0,0,.06);display:flex;flex-direction:column}
    .thumb{position:relative;padding-top:62%;background:#eee;overflow:hidden}
    .thumb img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;transition:transform .3s ease}
    .card:hover .thumb img{transform:scale(1.03)}
    .body{padding:14px}
    .title{display:flex;justify-content:space-between;align-items:flex-start;gap:10px}
    .title h3{margin:0;font-size:18px}
    .price{font-weight:700;color:#000}
    .desc{margin-top:8px;color:#444;font-size:14px;min-height:38px}
    .badge{display:inline-block;margin-top:10px;background:linear-gradient(135deg, var(--gold) 0%, #f1c14d 100%);color:#fff;padding:6px 10px;border-radius:999px;font-size:12px}
  </style>
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <a class="brand" href="index.php">Keyfet</a>
      <nav class="main-nav">
        <a href="index.php">Accueil</a>
        <a href="carte.php" class="active">Carte</a>
        <a href="reservation.php">Réserver</a>
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
    <a class="back" href="index.php"><i class="fas fa-arrow-left"></i> Retour</a>
    <h1>Notre Carte</h1>
    <div class="muted">Découvrez nos catégories et spécialités.</div>

    <?php if (!$cats): ?>
      <p class="muted">La carte n'est pas encore disponible.</p>
    <?php else: ?>
      <?php foreach ($cats as $cat): ?>
        <div class="section">
          <h2><?php echo htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
          <?php if (!empty($cat['description'])): ?>
            <div class="muted" style="margin-bottom:10px"><?php echo htmlspecialchars($cat['description'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
          <div class="grid">
            <?php $items = $itemsByCat[$cat['id']] ?? []; ?>
            <?php if (!$items): ?>
              <div class="muted">Aucun plat pour le moment.</div>
            <?php else: ?>
              <?php foreach ($items as $it): ?>
                <?php $img = $it['image_url'] ?: 'assets/img/videoframe_2626.png'; ?>
                <div class="card">
                  <div class="thumb"><img src="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($it['name'], ENT_QUOTES, 'UTF-8'); ?>"></div>
                  <div class="body">
                    <div class="title">
                      <h3><?php echo htmlspecialchars($it['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                      <div class="price"><?php echo number_format((float)$it['price'], 2, ',', ' '); ?> €</div>
                    </div>
                    <?php if (!empty($it['description'])): ?>
                      <div class="desc"><?php echo htmlspecialchars($it['description'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>
                    <div class="badge">Signature</div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
