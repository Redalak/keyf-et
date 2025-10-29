<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Keyfet — Scroll morph (one visible instance)</title>

    <!-- Police : on charge les graisses 400→800 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;800&display=swap" rel="stylesheet">

    <style>
        :root{
            /* Réglages scroll morph */
            --header-h: 72px;        /* hauteur du header */
            --pad: 20px;
            --trigger: 220;          /* distance de scroll (px) pour finir l’anim */
            --brand-final: 28px;     /* taille finale dans le header */
            --ease-p: 0;             /* 0→1, MAJ en JS */

            /* Styles header */
            --header-bg: rgba(255,255,255,.85);
            --header-blur: 8px;
            --ink:#111;
            --muted:#666;

            /* Styles bloc restaurant */
            --txt-color:#fff;
        }

        * {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }
        html, body { height: 100%; }
        body{
            margin:0;
            color:var(--ink);
            font-family: ui-serif, "Playfair Display", Georgia, serif;
            background:#fff;
        }

        /* =========================
           ANIMATIONS GLOBALES
        ==========================*/

        /* dézoom progressif du hero principal (Keyfet) */
        @keyframes heroDezoom {
            0% {
                transform: scale(1.15);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* apparition en fondu + léger slide up */
        @keyframes fadeUp {
            0% {
                opacity:0;
                transform:translateY(20px);
            }
            100% {
                opacity:1;
                transform:translateY(0);
            }
        }

        /* dézoom + fade du bloc resto (même principe) */
        @keyframes zoomReveal {
            0% {
                transform:scale(1.15);
                opacity:0;
            }
            100% {
                transform:scale(1);
                opacity:1;
            }
        }

        /* =========================
           HEADER FIXE + NAV
        ==========================*/

        .site-header{
            position: fixed;
            inset: 0 0 auto 0;
            height: var(--header-h);
            transform: translateY(calc((1 - var(--ease-p)) * -100%)); /* p=0 : hors-écran ; p=1 : en place */
            opacity: clamp(0, var(--ease-p), 1);
            backdrop-filter: blur(var(--header-blur));
            -webkit-backdrop-filter: blur(var(--header-blur));
            background: var(--header-bg);
            border-bottom: 1px solid rgba(0,0,0,.08);
            z-index: 20;
            transition: opacity .12s linear;
        }
        .header-inner{
            max-width: 1200px;
            height: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 0 var(--pad);
        }
        .nav{
            justify-self: end;
            display:flex;
            gap:20px;
        }
        .nav a{
            color:#111;
            text-decoration:none;
            font-size:15px;
            font-weight:600;
        }

        /* Cible finale au CENTRE du header */
        .brand-anchor-proxy{
            position: fixed;
            top: calc( (var(--header-h) - var(--brand-final)) / 2 );
            left: 50%;
            transform: translateX(-50%);
            font-size: var(--brand-final);
            font-weight: 800;
            letter-spacing: .06em;
            line-height: 1;
            visibility: hidden;
            pointer-events: none;
            z-index: 21;
        }

        /* =========================
           HERO PRINCIPAL (KEYFET)
        ==========================*/

        .hero{
            position: relative;
            min-height: 100svh;
            display: grid;
            place-items: center;
            overflow: clip;
        }

        .hero-img{
            position: absolute;
            inset:0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform-origin: center center;
            animation: heroDezoom 1.2s ease-out both; /* joue au chargement */
        }

        .hero::after{
            content:"";
            position:absolute;
            inset:0;
            background: linear-gradient(
                    to bottom,
                    rgba(0,0,0,.40),
                    rgba(0,0,0,.10) 40%,
                    rgba(0,0,0,0)
            );
            pointer-events:none;
        }

        .hero-overlay{
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 0 16px;
            color: white;
            text-shadow: 0 10px 30px rgba(0,0,0,.35);
        }

        /* Le Keyfet du hero sert de repère de mesure mais est INVISIBLE -> pas de doublon */
        .brand--hero{
            font-size: clamp(56px, 18vw, 220px);
            letter-spacing: .08em;
            color: white;
            visibility: hidden;
        }
        .tagline{
            margin: 12px 0 0;
            font-size: clamp(14px, 1.6vw, 18px);
            opacity: .9;
            visibility: hidden;
        }

        /* Élément UNIQUE visible qui “fait le trajet” (centre -> header) */
        .brand--float{
            position: fixed;
            left: 0;
            top: 0;
            z-index: 22;
            will-change: transform;
            pointer-events: none;
            transform-origin: center center;
            opacity: 0; /* révélé quand JS est prêt */
            color: white;
            mix-blend-mode: screen; /* blanc sur l'image, noir dans le header */
            font-weight: 800;
            letter-spacing: .06em;
            line-height: 1;
        }
        body.js-ready #brandFloat{ opacity: 1; }

        /* =========================
           CONTENU TEXTE CLASSIQUE
        ==========================*/
        .content{
            background:#fff;
        }
        .container{
            max-width: 900px;
            margin: 60px auto;
            padding: 0 16px;
            color:#222;
        }
        .container h2{ margin: 0 0 12px; }

        /* =========================
           BLOC RESTAURANT (SECONDE SECTION)
           - Animations AU SCROLL uniquement
        ==========================*/

        .hero-restaurant{
            position:relative;
            min-height:100vh;
            width:100%;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            isolation:isolate;
            background:#000; /* fallback */
            color:var(--txt-color);
        }

        /* état initial AVANT visibilité : image zoomée + transparente */
        .hero-restaurant-bg{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            object-fit:cover;
            object-position:center;
            transform:scale(1.15);
            opacity:0;
        }

        /* quand la section a .is-visible -> on lance l'anim zoomReveal */
        .hero-restaurant.is-visible .hero-restaurant-bg{
            animation: zoomReveal 1.2s ease-out forwards;
        }

        /* overlay sombre */
        .hero-restaurant::after {
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(
                    to bottom,
                    rgba(0,0,0,.45) 0%,
                    rgba(0,0,0,0) 40%,
                    rgba(0,0,0,.4) 100%
            );
            pointer-events:none;
        }

        /* bloc texte */
        .hero-restaurant-text{
            position:relative;
            z-index:2;
            max-width:1200px;
            width:100%;
            padding:0 1rem;
            text-align:center;
            text-shadow:0 20px 40px rgba(0,0,0,.8);

            font-size:clamp(1.1rem,0.6vw + 1rem,2rem); /* ~18px -> ~32px */
            line-height:1.4;
            font-weight:400;
            color:var(--txt-color);
        }
        .hero-restaurant-text p{
            margin:0.8em 0;
        }

        /* état initial AVANT scroll : lignes cachées */
        .reveal-line{
            opacity:0;
            transform:translateY(20px);
        }

        /* quand .is-visible est présent sur la section -> on anime chaque ligne avec délai */
        .hero-restaurant.is-visible .line-1{
            animation: fadeUp .8s cubic-bezier(.22,.61,.36,1) .2s forwards;
        }
        .hero-restaurant.is-visible .line-2{
            animation: fadeUp .8s cubic-bezier(.22,.61,.36,1) .45s forwards;
        }
        .hero-restaurant.is-visible .line-3{
            animation: fadeUp .8s cubic-bezier(.22,.61,.36,1) .65s forwards;
        }
        .hero-restaurant.is-visible .line-4{
            animation: fadeUp .8s cubic-bezier(.22,.61,.36,1) .85s forwards;
        }

        /* soulignement fin de la première ligne */
        .hero-restaurant-text .line-1 span{
            display:inline-block;
            padding-bottom:0.4rem;
            border-bottom:1px solid rgba(255,255,255,.9);
            white-space:nowrap;
        }

        /* plus de rond bleu : supprimé */

        /* =========================
           RESPONSIVE
        ==========================*/
        @media (max-width: 700px){
            :root{
                --header-h: 64px;
                --pad: 14px;
                --brand-final: 24px;
            }
            .nav{
                gap: 14px;
            }
            .nav a{
                font-size: 14px;
            }
        }

        @media(max-width:600px){
            .hero-restaurant-text{
                line-height:1.35;
            }
        }

        /* =========================
           ACCESSIBILITÉ : préfère moins d'animations
        ==========================*/
        @media (prefers-reduced-motion: reduce){
            .site-header{
                transform:none !important;
                opacity:1 !important;
            }
            #brandFloat{
                display:none !important;
            }

            /* Hero du haut : pas d'anim */
            .hero-img{
                animation: none !important;
                transform: scale(1) !important;
                opacity: 1 !important;
            }

            /* Bloc resto : tout visible direct,
               même sans la classe .is-visible */
            .hero-restaurant-bg{
                animation: none !important;
                transform: scale(1) !important;
                opacity: 1 !important;
            }
            .reveal-line{
                animation:none !important;
                opacity:1 !important;
                transform:none !important;
            }
        }
    </style>
</head>
<body>
<!-- Header -->
<header class="site-header" id="siteHeader" aria-label="Navigation principale">
    <div class="header-inner">
        <div></div>
        <div aria-hidden="true"></div> <!-- slot central -->
        <nav class="nav">
            <a href="#">Nouveautés</a>
            <a href="#">Femme</a>
            <a href="#">Homme</a>
            <a href="#">Cadeaux</a>
        </nav>
    </div>
</header>

<!-- Cible finale CENTRÉE dans le header -->
<div id="headerAnchorProxy" class="brand-anchor-proxy" aria-hidden="true">Keyfet</div>

<!-- HERO PRINCIPAL (Keyfet / morph) -->
<section class="hero">
    <img class="hero-img" src="assets/img/image.resto.jpg" alt="Visuel de collection" />
    <div class="hero-overlay">
        <h1 class="brand--hero" id="heroBrand" aria-hidden="true">Keyfet</h1>
        <p class="tagline" aria-hidden="true">New season • Timeless craftsmanship</p>
    </div>
</section>

<!-- Texte flottant UNIQUE qui bouge vers le header -->
<div id="brandFloat" class="brand--float">Keyfet</div>

<!-- CONTENU CLASSIQUE -->
<section class="content">
    <div class="container">
        <h2>Collection</h2>
        <p>Fais défiler légèrement pour voir l’animation. Remplace ce contenu par le tien.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer semper dolor ac erat molestie.</p>
        <p>Curabitur molestie velit id lectus viverra, eget sagittis arcu malesuada. Suspendisse potenti.</p>
    </div>
</section>

<!-- BLOC RESTAURANT (apparition au scroll) -->
<section class="hero-restaurant" id="heroRestaurant">
    <!-- Image de fond -->
    <img
        class="hero-restaurant-bg"
        src="https://restodeparis.com/wp-content/uploads/2022/09/restaurant-gastronomique-paris-sphere.jpg"
        alt="Intérieur du restaurant, ambiance chaleureuse, tables dressées"
    />

    <div class="hero-restaurant-text">
        <!-- Ligne 1 -->
        <p class="line-1 reveal-line">
            <span>Chaque espace du restaurant a son style et sa signature&nbsp;:</span>
        </p>

        <!-- Ligne 2 -->
        <p class="line-2 reveal-line">
            L’îlot central avec ses banquettes sur mesure et son éclairage<br/>
            surprenant…
        </p>

        <!-- Ligne 3 -->
        <p class="line-3 reveal-line">
            ou le salon à l’entrée avec son escalier sans issue énigmatique,
        </p>

        <!-- Ligne 4 -->
        <p class="line-4 reveal-line">
            ou encore le superbe bar émeraude illuminé par des sphère brillantes.
        </p>
    </div>
</section>

<script>
    // ===== Config & easing pour le scroll morph du titre Keyfet =====
    const TRIGGER = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--trigger')) || 220;
    const easeOutCubic = t => 1 - Math.pow(1 - t, 3);

    // ===== Éléments scroll morph =====
    const heroBrand  = document.getElementById('heroBrand');         // repère source (invisible dans le hero du haut)
    const proxy      = document.getElementById('headerAnchorProxy');  // cible finale (centre du header)
    const floatBrand = document.getElementById('brandFloat');         // texte flottant visible

    let srcRect = null, tgtRect = null, srcCenter = null, tgtCenter = null;

    function measure(){
        const src = heroBrand.getBoundingClientRect();
        const tgt = proxy.getBoundingClientRect();

        // Synchroniser la typo du flottant avec la source
        const srcStyle = getComputedStyle(heroBrand);
        floatBrand.style.fontSize = srcStyle.fontSize;
        floatBrand.style.letterSpacing = srcStyle.letterSpacing;
        floatBrand.style.fontFamily = srcStyle.fontFamily;
        floatBrand.textContent = heroBrand.textContent.trim();

        srcRect = src;
        tgtRect = tgt;
        srcCenter = { x: src.left + src.width/2, y: src.top + src.height/2 };
        tgtCenter = { x: tgt.left + tgt.width/2, y: tgt.top + tgt.height/2 };

        // Position de départ (au centre du hero du haut)
        floatBrand.style.transform =
            `translate(${srcCenter.x}px, ${srcCenter.y}px) translate(-50%,-50%) scale(1)`;

        document.body.classList.add('js-ready');
    }

    function updateOnScroll(){
        if (!srcRect || !tgtRect) return;

        const y = window.scrollY || window.pageYOffset;
        const raw = Math.min(Math.max(y / TRIGGER, 0), 1);
        const p = easeOutCubic(raw);

        // Partage du progress au CSS -> header qui glisse
        document.documentElement.style.setProperty('--ease-p', p.toFixed(5));

        // Interpolation du texte "Keyfet" (centre -> header)
        const cx = srcCenter.x + (tgtCenter.x - srcCenter.x) * p;
        const cy = srcCenter.y + (tgtCenter.y - srcCenter.y) * p;

        // Scale basé sur les largeurs
        const scale = (tgtRect.width / srcRect.width) || 1;
        const s = 1 + (scale - 1) * p;

        floatBrand.style.transform =
            `translate(${cx}px, ${cy}px) translate(-50%,-50%) scale(${s})`;

        // Crossfade couleur/blend (blanc sur image -> noir dans header)
        floatBrand.style.mixBlendMode = p > 0.85 ? 'normal' : 'screen';
        floatBrand.style.color        = p > 0.85 ? '#111'  : '#fff';
    }

    // rAF scroll loop
    let ticking = false;
    function onScroll(){
        if (!ticking){
            requestAnimationFrame(()=>{
                updateOnScroll();
                ticking = false;
            });
            ticking = true;
        }
    }

    const reflow = () => setTimeout(()=>{ measure(); updateOnScroll(); }, 50);

    // ===== Apparition du bloc restaurant au scroll =====
    const restoSection = document.getElementById('heroRestaurant');
    let restoShown = false;

    if ('IntersectionObserver' in window && restoSection){
        const obs = new IntersectionObserver((entries)=>{
            for (const entry of entries){
                if(entry.isIntersecting && !restoShown){
                    restoSection.classList.add('is-visible'); // déclenche les anims CSS
                    restoShown = true;
                }
            }
        },{
            threshold: 0.3 // ~30% visible
        });
        obs.observe(restoSection);
    } else {
        // fallback vieux nav : on montre directement
        restoSection.classList.add('is-visible');
    }

    // ===== Init globale =====
    window.addEventListener('load',  ()=>{ measure(); updateOnScroll(); });
    window.addEventListener('resize', reflow);
    window.addEventListener('orientationchange', reflow);
    window.addEventListener('scroll', onScroll, { passive:true });

    // re-mesure après chargement des polices
    if (document.fonts && document.fonts.ready){
        document.fonts.ready.then(reflow);
    }
</script>
</body>
</html>
