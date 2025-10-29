<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Coups de projecteur — slider</title>

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg-page:#f8f5f7;          /* fond global très clair rosé/gris */
            --ink:#1a1a1a;              /* texte principal foncé */
            --muted:#2b2b2b;            /* texte descriptif */
            --accent:#8a7a54;           /* doré/brun pour accents */
            --panel-bg:#ffffff;         /* fond bloc texte à droite */
            --panel-border:#e4e0d9;     /* contour fin beige/gris du panneau */
            --radius:6px;               /* arrondi subtil */
            --max-w:1280px;
            --gutter:24px;
        }

        *{
            box-sizing:border-box;
            -webkit-font-smoothing:antialiased;
            text-rendering:optimizeLegibility;
        }

        body{
            margin:0;
            background:var(--bg-page);
            color:var(--ink);
            font-family:"Libre Baskerville", Georgia, serif;
            line-height:1.5;
        }

        .spotlight{
            max-width:var(--max-w);
            margin:0 auto;
            padding:40px var(--gutter) 80px;
        }

        /* =======================
           HEADER DU MODULE
        ======================== */

        .spotlight-head{
            display:flex;
            flex-wrap:wrap;
            justify-content:space-between;
            align-items:flex-start;
            margin-bottom:32px;
        }

        .head-left{
            max-width:70ch;
        }

        .overline{
            font-family:"Libre Baskerville", Georgia, serif;
            font-size:12px;
            line-height:1.2;
            letter-spacing:.12em;
            text-transform:uppercase;
            font-weight:400;
            color:var(--ink);
            margin:0 0 12px;
        }

        .title-wrap{
            margin:0;
        }

        .main-title{
            margin:0;
            font-family:"Playfair Display", Georgia, serif;
            font-size:clamp(26px,1vw + 22px,36px);
            line-height:1.2;
            font-weight:500;
            letter-spacing:.03em;
            color:var(--ink);
            text-transform:uppercase;
        }

        .title-underline{
            width:80px;
            height:1px;
            background:var(--ink);
            margin-top:20px;
        }

        /* zone flèches + compteur */
        .head-right{
            display:flex;
            align-items:flex-start;
            gap:12px;
            font-family:"Libre Baskerville", Georgia, serif;
            font-size:16px;
            line-height:1.4;
            color:var(--accent);
            white-space:nowrap;
            margin-top:8px;
        }

        .arrow-btn{
            background:none;
            border:0;
            padding:0;
            margin:0;
            font-size:20px;
            line-height:1;
            font-weight:400;
            color:var(--accent);
            cursor:pointer;
            user-select:none;
            appearance:none;
            font-family:inherit;
        }

        .arrow-btn:focus{
            outline:1px solid var(--accent);
            outline-offset:2px;
        }

        .count{
            font-size:16px;
            line-height:1.4;
            letter-spacing:.05em;
            color:var(--accent);
            font-weight:400;
            min-width:60px;
            text-align:center;
            font-variant-numeric: tabular-nums;
        }

        /* =======================
           CORPS DU MODULE
           (image gauche + panneau texte droite)
        ======================== */

        .spotlight-body{
            display:flex;
            flex-wrap:nowrap;
            align-items:stretch;
            margin-top:24px;
            /* pas de border globale en desktop → on reste fidèle à la maquette */
        }

        /* image à gauche */
        .card-media{
            flex:1 1 auto;
            min-width:0;
            background:#000;
            position:relative;
            min-height:460px;

            /* arrondis à gauche */
            border-top-left-radius:var(--radius);
            border-bottom-left-radius:var(--radius);
            overflow:hidden;
        }

        .card-media img{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            object-fit:cover;
            object-position:center;
            display:block;
        }

        /* panneau texte à droite */
        .card-text{
            flex:0 0 420px;
            max-width:420px;
            background:var(--panel-bg);
            border:1px solid var(--panel-border);

            /* arrondis à droite */
            border-top-right-radius:var(--radius);
            border-bottom-right-radius:var(--radius);

            padding:32px 32px 40px;
            font-size:16px;
            line-height:1.6;
            color:var(--muted);
            display:flex;
            flex-direction:column;
            justify-content:flex-start;
        }

        .card-kicker{
            font-size:13px;
            line-height:1.4;
            letter-spacing:.12em;
            text-transform:uppercase;
            color:var(--muted);
            margin:0 0 16px;
            font-weight:400;
        }

        .card-headline{
            margin:0 0 20px;
            font-family:"Playfair Display", Georgia, serif;
            font-size:22px;
            line-height:1.4;
            font-weight:400;
            font-style:italic;
            color:var(--accent);
        }

        .card-desc{
            margin:0 0 28px;
            font-size:16px;
            line-height:1.6;
            color:var(--ink);
            font-weight:400;
        }

        .card-link{
            margin-top:auto;
            font-size:14px;
            line-height:1.4;
            letter-spacing:.08em;
            text-transform:uppercase;
            font-family:"Libre Baskerville", Georgia, serif;
            font-weight:400;
            color:var(--accent);
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            gap:8px;
        }

        .card-link .arrow-right{
            font-size:18px;
            line-height:1;
        }

        .card-link:focus{
            outline:1px solid var(--accent);
            outline-offset:2px;
        }

        /* =======================
           RESPONSIVE
        ======================== */

        @media(max-width:900px){
            .spotlight-body{
                flex-direction:column;

                /* sur mobile : carte entière encadrée + arrondie */
                border:1px solid var(--panel-border);
                border-radius:var(--radius);
                overflow:hidden;
            }

            .card-media{
                min-height:320px;
                width:100%;
                border-bottom:1px solid var(--panel-border);

                /* enlever l'arrondi gauche séparé, c'est la carte entière qui est arrondie maintenant */
                border-top-left-radius:0;
                border-bottom-left-radius:0;
            }

            .card-text{
                flex:unset;
                max-width:100%;
                border:0; /* on enlève la bordure interne */
                border-radius:0;
                padding:24px var(--gutter) 32px;
            }

            .head-right{
                order:-1;
                width:100%;
                justify-content:flex-end;
                margin-bottom:16px;
            }
        }

        @media(max-width:500px){
            .main-title{
                font-size:24px;
            }
            .arrow-btn{
                font-size:18px;
            }
            .count{
                font-size:14px;
                min-width:auto;
            }
            .card-headline{
                font-size:20px;
            }
        }
    </style>
</head>
<body>

<section class="spotlight" id="spotlight">

    <!-- HEADER / TITRES -->
    <header class="spotlight-head">
        <div class="head-left">
            <p class="overline">L'OISEAU BLANC</p>

            <div class="title-wrap">
                <h2 class="main-title">COUPS DE PROJECTEUR</h2>
                <div class="title-underline"></div>
            </div>
        </div>

        <div class="head-right">
            <button class="arrow-btn prev" id="prevBtn" aria-label="Précédent">←</button>
            <span class="count" id="slideCounter">01/04</span>
            <button class="arrow-btn next" id="nextBtn" aria-label="Suivant">→</button>
        </div>
    </header>

    <!-- SLIDER (image + texte) -->
    <article class="spotlight-body">
        <!-- IMAGE -->
        <figure class="card-media">
            <img
                id="spotlightImg"
                src=""
                alt=""
            />
        </figure>

        <!-- TEXTE -->
        <div class="card-text">
            <p class="card-kicker" id="spotlightKicker"></p>

            <h3 class="card-headline" id="spotlightHeadline"></h3>

            <p class="card-desc" id="spotlightDesc"></p>

            <a class="card-link" id="spotlightLink" href="#" target="_self" rel="noopener">
                <span>EN SAVOIR PLUS</span>
                <span class="arrow-right" aria-hidden="true">→</span>
            </a>
        </div>
    </article>

</section>

<script>
    // ===========================
    // Slides : mets tes contenus ici
    // ===========================
    const slides = [
        {
            kicker: "DESSERT SPÉCIAL OCTOBRE ROSE",
            headline: "Peninsula In Pink",
            desc: "Dans le cadre de l’opération Peninsula in Pink, le restaurant deux étoiles L’Oiseau Blanc met à l’honneur la créativité d’Anne Coruble à travers la Rosacée framboise. Cette composition audacieuse associe la profondeur du radis fermenté, la vivacité d’une fraîcheur herbacée et la douceur aérienne d’une meringue lactique. Face à la Tour Eiffel, ce dessert incarne la rencontre entre intensité et délicatesse, tout en contribuant au soutien de l’association Les Bonnes Fées grâce au reversement des fonds générés.",
            img: "https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?auto=format&fit=crop&w=1600&q=80",
            alt: "Dessert gastronomique rose, dressage raffiné et verre de vin rosé",
            link: "#"
        },
        {
            kicker: "SIGNATURE DU CHEF",
            headline: "Caviar & Fleurs d’agrumes",
            desc: "Une rencontre iodée entre un caviar d’exception, une crème légère infusée aux zestes d’agrumes rares et une gelée cristalline au yuzu. La bouche oscille entre salinité pure et amertume élégante.",
            img: "https://images.unsplash.com/photo-1473093295043-cdd812d0e601?auto=format&fit=crop&w=1600&q=80",
            alt: "Assiette gastronomique salée, dressage minimaliste et luxueux",
            link: "#"
        },
        {
            kicker: "ACCORD METS & VINS",
            headline: "Sublime Rosé de France",
            desc: "Un accord pensé autour de la fraîcheur. Vin rosé aux notes de groseille blanche, servi légèrement rafraîchi, qui souligne l’acidité vive et la gourmandise du plat sans l’écraser.",
            img: "https://images.unsplash.com/photo-1529692236671-f1dc28a36a06?auto=format&fit=crop&w=1600&q=80",
            alt: "Verre de vin rosé tenu à la main, ambiance table chic",
            link: "#"
        },
        {
            kicker: "EXCLUSIVITÉ SAISONNIÈRE",
            headline: "Truffe & Lait Ribot",
            desc: "Un contraste chaud-froid autour d’une émulsion lactée au lait ribot, relevée par une râpée généreuse de truffe noire. Texture voluptueuse, finale longue et boisée.",
            img: "https://images.unsplash.com/photo-1551189013-45b7b7cded15?auto=format&fit=crop&w=1600&q=80",
            alt: "Plat raffiné avec truffe, dressage minimaliste sur assiette blanche",
            link: "#"
        }
    ];

    // ===========================
    // Récup des éléments
    // ===========================
    const imgEl = document.getElementById("spotlightImg");
    const kickerEl = document.getElementById("spotlightKicker");
    const headlineEl = document.getElementById("spotlightHeadline");
    const descEl = document.getElementById("spotlightDesc");
    const linkEl = document.getElementById("spotlightLink");
    const counterEl = document.getElementById("slideCounter");

    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    // index actuel
    let currentIndex = 0;

    // helpers compteur 01/04
    function pad2(n){
        const human = n + 1;
        return human < 10 ? "0" + human : "" + human;
    }
    function padTotal(n){
        return n < 10 ? "0" + n : "" + n;
    }

    // maj du contenu selon currentIndex
    function renderSlide(){
        const slide = slides[currentIndex];

        imgEl.src = slide.img;
        imgEl.alt = slide.alt;

        kickerEl.textContent = slide.kicker;
        headlineEl.textContent = slide.headline;
        descEl.textContent = slide.desc;
        linkEl.href = slide.link;

        counterEl.textContent = `${pad2(currentIndex)}/${padTotal(slides.length)}`;
    }

    // navigation
    function goNext(){
        currentIndex = (currentIndex + 1) % slides.length;
        renderSlide();
    }

    function goPrev(){
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        renderSlide();
    }

    prevBtn.addEventListener("click", goPrev);
    nextBtn.addEventListener("click", goNext);

    // init
    renderSlide();
</script>

</body>
</html>
