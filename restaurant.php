<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Nos Restaurants • Keyfet</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  >
  <style>
    :root{--gold:#d4af37;--bg:#f8f5f7;--text:#1a1a1a;--muted:#666;}
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);color:var(--text);font-family:ui-serif,"Playfair Display",Georgia,serif}
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
    .hero{padding:80px 20px;text-align:center;background:#fff;border-bottom:1px solid rgba(0,0,0,0.05)}
    .hero h1{font-size:48px;margin:0 0 12px}
    .hero p{max-width:620px;margin:0 auto;color:var(--muted);font-size:18px}
    .content{max-width:1100px;margin:40px auto;padding:0 20px}
    .map-section{margin-bottom:40px}
    .map-leaflet{height:420px;border-radius:18px;overflow:hidden;border:1px solid rgba(0,0,0,0.08);box-shadow:0 18px 40px rgba(0,0,0,0.08)}
    #map{width:100%;height:420px}
    .leaflet-container{font:inherit}
    .map-note{margin-top:12px;color:var(--muted);font-size:14px;text-align:center}
    .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    @media (max-width:992px){.grid{grid-template-columns:repeat(2,1fr)}}
    @media (max-width:720px){.grid{grid-template-columns:1fr}}
    .card{background:#fff;border:1px solid rgba(0,0,0,0.05);border-radius:16px;box-shadow:0 14px 30px rgba(0,0,0,0.05);overflow:hidden;display:flex;flex-direction:column;cursor:pointer;transition:transform .2s ease,box-shadow .2s ease}
    .card:hover{transform:translateY(-3px);box-shadow:0 18px 36px rgba(0,0,0,0.08)}
    .card-header{padding:20px;border-bottom:1px solid rgba(0,0,0,0.05)}
    .card-header h2{margin:0;font-size:24px}
    .badge{display:inline-block;margin-top:8px;padding:6px 12px;border-radius:999px;background:linear-gradient(135deg,var(--gold) 0%,#f1c14d 100%);color:#fff;font-size:12px;letter-spacing:0.08em}
    .card-body{padding:20px;display:flex;flex-direction:column;gap:16px}
    .info{display:flex;align-items:flex-start;gap:12px;color:var(--muted);font-size:15px}
    .info i{color:var(--gold);margin-top:4px}
    .hours{background:#f0ece1;border-radius:12px;padding:16px}
    .actions{display:flex;gap:12px;flex-wrap:wrap}
    .actions a,.actions button{flex:1;text-align:center;padding:12px 16px;border-radius:10px;text-decoration:none;text-transform:uppercase;font-size:13px;font-weight:600;letter-spacing:0.08em;cursor:pointer;transition:transform .2s ease,box-shadow .2s ease}
    .actions a:hover,.actions button:hover{transform:translateY(-2px);box-shadow:0 12px 24px rgba(0,0,0,0.08)}
    .actions button{border:none;font-family:inherit}
    .btn-map{background:#fff;border:1px solid rgba(0,0,0,0.1);color:#444}
    .btn-map:focus{outline:2px solid rgba(212,175,55,0.4);outline-offset:2px}
    .btn-route{background:#fff;border:1px solid #d4af37;color:#a07d20}
    @media (max-width:520px){.actions a,.actions button{flex:1 1 100%}}
  </style>
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <a class="brand" href="index.php">Keyfet</a>
      <nav class="main-nav">
        <a href="index.php">Accueil</a>
        <a href="carte.php">Carte</a>
        <a href="restaurant.php" class="active">Nos restaurants</a>
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

  <section class="hero">
    <h1>Nos Restaurants</h1>
    <p>Retrouvez les adresses Keyfet dans toute l’Île-de-France. Trois tables, trois ambiances différentes, une même passion pour les grillades.</p>
  </section>

  <main class="content">
    <section class="map-section" aria-label="Carte des restaurants Keyfet">
      <div id="map" class="map-leaflet" role="region" aria-roledescription="carte interactive"></div>
      <div class="map-note">Cliquez sur un restaurant ou un marqueur pour afficher les détails et obtenir l'itinéraire.</div>
    </section>
    <div class="grid">
      <article class="card">
        <div class="card-header">
          <h2>Keyf-et Grill House</h2>
          <span class="badge">Villepinte</span>
        </div>
        <div class="card-body">
          <div class="info"><i class="fas fa-map-marker-alt"></i><div>1 avenue des Entrepreneurs<br>95400 Villiers-le-Bel</div></div>
          <div class="info"><i class="fas fa-phone"></i><a href="tel:0199417088">01 99 41 70 88</a></div>
          <div class="hours">
            <strong>Horaires</strong><br>
            Lundi - Dimanche: 11:00 – 15:00 / 18:30 – 23:00
          </div>
          <div class="actions">
            <button class="btn-map" type="button" data-map-index="0">Voir sur la carte</button>
            <a class="btn-route" href="https://maps.google.com/?q=1+Avenue+des+Entrepreneurs+95400+Villiers-le-Bel" target="_blank" rel="noopener">Itinéraire</a>
          </div>
        </div>
      </article>

      <article class="card">
        <div class="card-header">
          <h2>Keyf-et Grill House</h2>
          <span class="badge">Gonesse</span>
        </div>
        <div class="card-body">
          <div class="info"><i class="fas fa-map-marker-alt"></i><div>ZAC l'issoinvilliers<br>3-5 avenue des Entrepreneurs<br>95500 Gonesse</div></div>
          <div class="info"><i class="fas fa-phone"></i><a href="tel:0955295049">09 55 29 50 49</a></div>
          <div class="hours">
            <strong>Horaires</strong><br>
            Lundi - Dimanche: 08:30 – 22:00
          </div>
          <div class="actions">
            <button class="btn-map" type="button" data-map-index="1">Voir sur la carte</button>
            <a class="btn-route" href="https://maps.google.com/?q=3-5+Avenue+des+Entrepreneurs+95500+Gonesse" target="_blank" rel="noopener">Itinéraire</a>
          </div>
        </div>
      </article>

      <article class="card">
        <div class="card-header">
          <h2>Keyf-et Grill House</h2>
          <span class="badge">Nogent-sur-Oise</span>
        </div>
        <div class="card-body">
          <div class="info"><i class="fas fa-map-marker-alt"></i><div>Parc d'activités du Saule<br>171 rue Jean Monnet<br>60180 Nogent-sur-Oise</div></div>
          <div class="info"><i class="fas fa-phone"></i><a href="tel:0955289029">09 55 28 90 29</a></div>
          <div class="hours">
            <strong>Horaires</strong><br>
            Lundi - Dimanche: 09:00 – 22:00
          </div>
          <div class="actions">
            <button class="btn-map" type="button" data-map-index="2">Voir sur la carte</button>
            <a class="btn-route" href="https://maps.google.com/?q=171+Rue+Jean+Monnet+60180+Nogent-sur-Oise" target="_blank" rel="noopener">Itinéraire</a>
          </div>
        </div>
      </article>
    </div>
  </main>

  <script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  ></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (!window.L) {
        return;
      }

      const restaurants = [
        {
          name: 'Keyf-et Grill House',
          city: 'Villiers-le-Bel',
          address: '1 avenue des Entrepreneurs, 95400 Villiers-le-Bel',
          coords: [49.0000444, 2.3903035],
          mapsUrl: 'https://maps.google.com/?q=1+Avenue+des+Entrepreneurs+95400+Villiers-le-Bel'
        },
        {
          name: 'Keyf-et Grill House',
          city: 'Gonesse',
          address: '3-5 avenue des Entrepreneurs, 95500 Gonesse',
          coords: [48.994872, 2.425381],
          mapsUrl: 'https://maps.google.com/?q=3-5+Avenue+des+Entrepreneurs+95500+Gonesse'
        },
        {
          name: 'Keyf-et Grill House',
          city: 'Nogent-sur-Oise',
          address: '171 rue Jean Monnet, 60180 Nogent-sur-Oise',
          coords: [49.2862096, 2.4600988],
          mapsUrl: 'https://maps.google.com/?q=171+Rue+Jean+Monnet+60180+Nogent-sur-Oise'
        }
      ];

      const mapElement = document.getElementById('map');
      if (!mapElement) {
        return;
      }

      const map = L.map(mapElement, { scrollWheelZoom: false, tap: true });
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      restaurants.forEach((restaurant, index) => {
        const marker = L.marker(restaurant.coords, { title: restaurant.name }).addTo(map);
        marker.bindPopup(`
          <strong>${restaurant.name}</strong><br>
          ${restaurant.address}<br>
          ${restaurant.city}<br>
          <a href="${restaurant.mapsUrl}" target="_blank" rel="noopener">Ouvrir dans Google Maps</a>
        `);
        restaurant.marker = marker;
        restaurant.index = index;
      });

      const group = L.featureGroup(restaurants.map(r => r.marker));
      if (restaurants.length === 1) {
        map.setView(restaurants[0].coords, 13);
      } else {
        map.fitBounds(group.getBounds(), { padding: [32, 32] });
      }

      const focusOn = (index) => {
        const target = restaurants[index];
        if (!target) return;
        map.flyTo(target.coords, 15, { duration: 0.8 });
        target.marker.openPopup();
        const y = mapElement.getBoundingClientRect().top + window.scrollY - 120;
        window.scrollTo({ top: y, behavior: 'smooth' });
      };

      const refreshSize = () => map.invalidateSize();
      window.addEventListener('load', refreshSize, { once: true });
      setTimeout(refreshSize, 300);

      document.querySelectorAll('[data-map-index]').forEach(btn => {
        btn.addEventListener('click', (event) => {
          event.preventDefault();
          const index = Number(btn.getAttribute('data-map-index'));
          focusOn(index);
        });
      });

      document.querySelectorAll('.card').forEach((card, index) => {
        card.addEventListener('click', (event) => {
          if (event.target.closest('.btn-route')) {
            return;
          }
          focusOn(index);
        });
      });
    });
  </script>
</body>
</html>
