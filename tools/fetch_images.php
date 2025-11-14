<?php
// Simple script to download images to assets/img/carte from a list of URLs
// How to use:
// 1) Put this file at /tools/fetch_images.php
// 2) Open in browser: http://localhost:8888/keyf-et/keyf-et/tools/fetch_images.php (MAMP) or http://localhost/keyf-et/keyf-et/tools/fetch_images.php (WAMP)
// 3) Paste one mapping per line: <url>;<filename>
//    Example:
//    https://keyfet.fr/wp-content/uploads/2024/01/assiette-mezze.jpg;assiette-mezze.jpg
// 4) Click "Télécharger". Images will be saved into ../assets/img/carte/

declare(strict_types=1);

$saveDir = realpath(__DIR__ . '/../assets/img/carte');
if ($saveDir === false) {
    http_response_code(500);
    echo 'Dossier cible introuvable: assets/img/carte';
    exit;
}

$result = [];
$error = '';

function download_image(string $url, string $dest): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (ImageFetcher)'
    ]);
    $data = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    if ($data === false || $status >= 400) {
        return ['ok' => false, 'msg' => 'HTTP ' . $status . ' ' . $err];
    }
    if (file_put_contents($dest, $data) === false) {
        return ['ok' => false, 'msg' => 'Ecriture impossible: ' . basename($dest)];
    }
    return ['ok' => true, 'msg' => 'OK'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lines = $_POST['mappings'] ?? '';
    $lines = str_replace(["\r\n", "\r"], "\n", $lines);
    $rows = array_filter(array_map('trim', explode("\n", $lines)));
    foreach ($rows as $i => $row) {
        $parts = array_map('trim', explode(';', $row));
        if (count($parts) < 2) {
            $result[] = ['line' => $row, 'status' => 'FAIL', 'details' => 'Format attendu: <url>;<filename>'];
            continue;
        }
        [$url, $filename] = $parts;
        if (!preg_match('~^https?://~i', $url)) {
            $result[] = ['line' => $row, 'status' => 'FAIL', 'details' => 'URL invalide'];
            continue;
        }
        if (!preg_match('~^[a-z0-9._\-]+$~i', $filename)) {
            $result[] = ['line' => $row, 'status' => 'FAIL', 'details' => 'Nom de fichier invalide'];
            continue;
        }
        $dest = $saveDir . DIRECTORY_SEPARATOR . $filename;
        $resp = download_image($url, $dest);
        $result[] = ['line' => $row, 'status' => $resp['ok'] ? 'OK' : 'FAIL', 'details' => $resp['msg']];
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Téléchargement images carte</title>
  <style>
    body{font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial; margin:20px;color:#111}
    textarea{width:100%;min-height:220px}
    .wrap{max-width:900px;margin:0 auto}
    .muted{color:#666}
    table{width:100%;border-collapse:collapse;margin-top:16px}
    th,td{border-bottom:1px solid #eee;padding:8px;text-align:left;font-size:14px}
    .ok{color:#137a1a}
    .fail{color:#b40000}
    .tip{background:#f7f7f9;border:1px solid #eee;border-radius:8px;padding:10px;margin:10px 0}
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Télécharger des images vers assets/img/carte/</h1>
    <div class="tip">
      Format: <code>URL;fichier.jpg</code> — un par ligne. Exemple:<br />
      <code>https://example.com/img/assiette-mezze.jpg;assiette-mezze.jpg</code>
    </div>
    <form method="post">
      <textarea name="mappings" placeholder="https://.../assiette-mezze.jpg;assiette-mezze.jpg
https://.../kebab-adana.jpg;kebab-adana.jpg"></textarea>
      <div style="margin-top:10px">
        <button type="submit">Télécharger</button>
      </div>
    </form>

    <?php if (!empty($result)): ?>
      <h2>Résultats</h2>
      <table>
        <thead>
          <tr><th>Ligne</th><th>Statut</th><th>Détails</th></tr>
        </thead>
        <tbody>
          <?php foreach ($result as $r): ?>
            <tr>
              <td><?php echo htmlspecialchars($r['line'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="<?php echo $r['status']==='OK'?'ok':'fail'; ?>"><?php echo $r['status']; ?></td>
              <td><?php echo htmlspecialchars($r['details'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <h3>Comment trouver l'URL d'une image</h3>
    <ol>
      <li>Ouvre la page (ex: galerie ou la fiche du plat)</li>
      <li>Clic droit sur l'image → «Ouvrir l'image dans un nouvel onglet» ou «Copier l'adresse de l'image»</li>
      <li>Colle l'URL dans la zone ci-dessus avec le nom de fichier souhaité</li>
    </ol>
  </div>
</body>
</html>
