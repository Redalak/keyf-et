<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Keyfet — Scroll morph + Spotlight</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        /* Style de base */
        body {
            font-family: 'Nunito', sans-serif;
            line-height: 1.7;
            color: #333;
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 400;
            margin: 1.5rem 0 1.2rem;
            line-height: 1.3;
            color: #2c2c2c;
        }
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8) translateX(30px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateX(0);
            }
        }

        .brand--hero {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 300; /* Plus fin */
            font-size: clamp(2.5rem, 8vw, 6rem);
            line-height: 1.1; /* Légèrement plus d'espacement pour la lisibilité */
            margin: 0;
            color: var(--text-color) !important;
            text-shadow: 0 2px 4px rgba(255,255,255,0.2);
            letter-spacing: 0.5px; /* Légèrement plus d'espacement entre les lettres */
            text-transform: none; /* Suppression de la transformation en majuscules si elle existe */
            animation: zoomIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0; /* Démarre invisible */
            transform-origin: center; /* Point d'origine du zoom */
        }

        .brand--float {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 300; /* Plus fin */
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .brand-anchor-proxy {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 300; /* Plus fin */
        }
        /* Styles pour la section Notre Carte - Version Premium */
        .carte-section {
            padding: 120px 0;
            background-color: #f5f5f5;
            opacity: 0;
            transform: translateY(50px);
            will-change: opacity, transform;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgcGF0dGVyblRyYW5zZm9ybT0icm90YXRlKDQ1KSI+PHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjUwIiBoZWlnaHQ9IjUwIiBmaWxsPSIjZjBmMGYwIj48L3JlY3Q+PHBhdGggZD0iTTAgNTBINFYwSDBWNTBaTTUwIDBINjBWNTBINTBWMFpNNTAgNTBINjBWMTBINTBWNTBaTTAgNjBINDBWNTBIMFY2MFpNNjAgMEg1MFY0MEg2MFYwWk0xMCAwSDBWMTBIMTBWMFpNNDAgNjBINjBWNTBINDBWNjBaTTAgMjBIMTBWMzBIMFYyMFpNNjAgMzBINDhWNDBINjBWMzBaTTAgNTBIMTBWNjBIMFY1MFpNNTAgNjBINjBWNTBINTBWNjBaTTAgMTBIMTBWMjBIMFYxMFpNMzAgNjBINDhWNTBIMzBWNjBaTTAgNDBIMTBWNTBIMFY0MFpNMjAgNjBIMzBWNTBIMjBWNjBaTTAgMzBIMTBWNDBIMFYzMFpNMTAgNjBIMjBWNTBIMTBWNjBaTTAgMjBIMTBWMzBIMFYyMFpNMjAgNjBIMzBWNTBIMjBWNjBaTTAgMTBIMTBWMjBIMFYxMFpNMzAgNjBINDBWNTBIMzBWNjBaTTAgMEgxMFYxMEgwVjBaTTQwIDYwSDUwVjUwSDQwVjYwWiIgZmlsbD0iI2U1ZTVlNSI+PC9wYXRoPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSI+PC9yZWN0Pjwvc3ZnPg==');
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        .carte-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgdmlld0JveD0iMCAwIDYwIDYwIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNlZGVkZWQiIGZpbGwtb3BhY2l0eT0iMC40Ij48cGF0aCBkPSJNMzYgMzRjMC0yLjIwOS0xLjc5MS00LTQtNHMtNCAxLjc5MS00IDQgMS43OTEgNCA0IDQgNC0xLjc5MSA0LTR6bS0yMiAxMGMwLTIuMjA5LTEuNzkxLTQtNC00cy00IDEuNzkxLTQgNCAxLjc5MSA0IDQgNCA0LTEuNzkxIDQtNHptMC0yMGMwLTIuMjA5LTEuNzkxLTQtNC00cy00IDEuNzkxLTQgNCAxLjc5MSA0IDQgNCA0LTEuNzkxIDQtNHoiLz48L2c+PC9nPjwvc3ZnPg==');
            opacity: 0.5;
            z-index: 0;
        }

        .carte-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 30px;
            position: relative;
            z-index: 1;
            display: flex;
            min-height: 100vh;
            align-items: center;
        }

        .carte-scroll-container {
            display: flex;
            height: 100%;
            position: relative;
        }

        .carte-video-wrapper {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }

        .carte-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
        }

        .carte-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .carte-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .carte-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform-origin: center;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            transform: scale(1.3); /* Zoom initial plus important */
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
        }

        .carte-content {
            width: 50%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: 50px 40px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
            margin-right: 50%;
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .carte-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.1);
        }


        .carte-description {
            margin: 30px 0 40px;
            font-size: 1.1em;
            line-height: 1.8;
            color: #555;
            position: relative;
            padding-left: 20px;
            border-left: 3px solid #d4af37;
        }

        .carte-menus {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin: 50px 0 40px;
        }

        .menu-category {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .menu-category:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .menu-category h3 {
            color: #222;
            margin: 0 0 20px 0;
            font-size: 1.5em;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
            font-family: 'Playfair Display', serif;
        }

        .menu-category h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #d4af37, #f1c14d);
            border-radius: 3px;
        }

        .menu-category ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-category li {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .menu-category li:hover {
            padding-left: 5px;
        }

        .menu-category li:last-child {
            border-bottom: none;
        }

        .menu-category span {
            color: #d4af37;
            font-weight: 600;
            font-size: 1.05em;
            white-space: nowrap;
            margin-left: 15px;
        }

        .carte-cta {
            text-align: center;
            margin-top: 60px;
            position: relative;
        }

        .carte-cta:before {
            content: '';
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #d4af37, transparent);
        }

        .btn-reserver {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 40px;
            background: linear-gradient(135deg, #d4af37 0%, #f1c14d 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1em;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-reserver:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-reserver:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
        }

        .btn-reserver:hover:before {
            left: 100%;
        }

        .btn-reserver:active {
            transform: translateY(0);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        @media (max-width: 1024px) {
            .carte-container {
                gap: 40px;
            }

            .carte-content {
                flex: 100%;
            }
        }

        @media (max-width: 1024px) {
            .carte-container {
                flex-direction: column;
                padding: 0 20px;
            }

            .carte-content,
            .carte-image-wrapper {
                width: 100%;
                position: relative;
                min-height: auto;
            }

            .carte-content {
                margin: 0;
                padding: 30px 20px;
            }

            .carte-image-wrapper {
                position: relative;
                height: 300px;
                margin-bottom: 30px;
            }

            .carte-menus {
                grid-template-columns: 1fr;
            }

            .carte-cta {
                margin-top: 30px;
            }
        }
        }


        @media (max-width: 768px) {
            .carte-container {
                flex-direction: column;
            }

        }
        /* Styles pour le menu latéral */
        /* Style du bouton hamburger avec Font Awesome */
        /* Style du bouton hamburger */
        #openMenu {
            background: none !important;
            border: none !important;
            cursor: pointer;
            width: 25px !important;
            height: 20px !important;
            position: absolute !important;
            left: 15px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 1000 !important;
            padding: 0 !important;
            display: flex !important;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Création des 3 traits du menu hamburger */
        #openMenu::before,
        #openMenu::after,
        #openMenu span {
            content: '';
            display: block;
            width: 100%;
            height: 1.5px;
            background-color: #8a7a54;
            border-radius: 2px;
        }

        #openMenu::before {
            transform-origin: 0% 50%;
        }

        #openMenu::after {
            transform-origin: 0% 50%;
        }

        /* Style pour le bouton de fermeture */
        #closeMenu {
            position: absolute;
            right: 15px;
            top: 15px;
            background: #8a7a54;
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 4px;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Cacher le bouton sur les grands écrans */
        @media (min-width: 1025px) {
            #openMenu {
                display: none;
            }
        }

        .menu-toggle:focus {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background-color: var(--header-bg);
            backdrop-filter: blur(var(--header-blur));
            padding: 20px;
            z-index: 999;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar-nav {
            margin-top: 60px;
        }

        .sidebar-nav a {
            display: block;
            padding: 12px 0;
            color: var(--ink);
            text-decoration: none;
            font-size: 18px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            transition: color 0.2s;
        }

        .sidebar-nav a:hover {
            color: var(--accent);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .overlay.open {
            opacity: 1;
            visibility: visible;
        }

        /* Styles du header */
        .site-header {
            position: relative;
            width: 100%;
            height: var(--header-h);
            z-index: 1000;
            background: var(--header-bg);
            backdrop-filter: blur(var(--header-blur));
            -webkit-backdrop-filter: blur(var(--header-blur));
        }

        .header-inner {
            max-width: var(--max-w);
            margin: 0 auto;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 var(--pad);
            position: relative;
        }

        @media (max-width: 1024px) {
            /* Ajustements pour le header */
            .site-header {
                padding-left: 70px; /* Espace pour le bouton */
            }

            .header-inner {
                width: 100%;
                display: flex;
                justify-content: flex-end;
                align-items: center;
                padding: 0 20px;
            }

            /* Style du bouton menu */
            .menu-toggle {
                position: absolute;
                left: 20px;
                top: 50%;
                transform: translateY(-50%);
                display: flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                background: #8a7a54;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                z-index: 1001;
            }

            /* Cacher la navigation principale sur mobile */
            .main-nav {
                display: none;
            }

            /* Ajustement du contenu principal */
            .hero {
                margin-top: 0;
            }
        }

        :root{
            /* Réglages scroll morph */
            --header-h: 72px;        /* hauteur du header */
            --pad: 20px;
            --trigger: 220;          /* distance de scroll (px) pour finir l’anim */
            --brand-final: 28px;     /* taille finale du logo dans le header */
            --ease-p: 0;             /* 0→1, MAJ en JS */

            /* Styles header / global */
            --header-bg: rgba(255,255,255,.85);
            --header-blur: 8px;
            --ink:#111;
            --muted:#666;

            /* Styles bloc restaurant */
            --txt-color:#fff;

            /* Variables du bloc spotlight */
            --bg-page:#f8f5f7;          /* fond doux rosé/gris du module spotlight (si tu veux l'utiliser) */
            --accent:#8a7a54;           /* doré/brun */
            --panel-bg:#ffffff;         /* fond panneau texte spotlight */
            --panel-border:#e4e0d9;     /* contour fin spotlight */
            --radius:6px;               /* arrondi subtil spotlight */
            --max-w:1280px;
            --gutter:24px;
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

        /* dézoom + fade pour images / backgrounds */
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

        /* apparition du bloc spotlight (section "COUPS DE PROJECTEUR") */
        @keyframes spotlightReveal {
            0% {
                opacity:0;
                transform:translateY(40px) scale(.98);
            }
            100% {
                opacity:1;
                transform:translateY(0) scale(1);
            }
        }

        /* balayage lumineux type reflet sur le texte restaurant */
        @keyframes shineSweep {
            0% {
                transform:translateX(-60%) skewX(-20deg);
            }
            100% {
                transform:translateX(160%) skewX(-20deg);
            }
        }

        /* =========================
           HEADER FIXE + NAV
        ==========================*/

        .site-header{
            position: fixed;
            inset: 0 0 auto 0;
            height: var(--header-h);
            display: flex;
            align-items: center;
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
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 calc(var(--pad) * 2);
            position: relative;
        }
        .nav{
            display: flex;
            align-items: center;
            gap: 30px;
            margin-left: auto;
        }

        .main-nav {
            display: flex;
            gap: 20px;
        }

        .social-nav {
            display: flex;
            gap: 18px;
            padding: 0 25px 0 0;
            margin-right: 15px;
            position: relative;
        }

        .social-nav::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 1px;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .main-nav a {
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 10px 24px;
            border-radius: 30px;
            background: linear-gradient(135deg, #d4af37 0%, #f1c14d 100%);
            border: 1px solid #d4af37;
            box-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .main-nav a:hover {
            background: linear-gradient(135deg, #c19b2e 0%, #e0b645 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
            color: #ffffff;
        }

        .main-nav a:active {
            transform: translateY(0);
            box-shadow: 0 1px 5px rgba(212, 175, 55, 0.3);
        }

        .social-nav a {
        {{ ... }}
            font-size: 20px;
            color: #000000;
            transition: color 0.2s;
        }

        .social-nav a:hover {
            color: #d4af37;
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

        /* repère invisible pour morph */
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

        /* Élément flottant qui “voyage” vers le header */
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
           BLOC SPOTLIGHT (COUPS DE PROJECTEUR)
        ==========================*/

        .spotlight{
            max-width:var(--max-w);
            margin:0 auto;
            padding:40px var(--gutter) 80px;

            /* typo du bloc */
            font-family:"Libre Baskerville", Georgia, serif;
            line-height:1.5;
            color:var(--ink);

            /* état AVANT scroll : invisible / décalé */
            opacity:0;
            transform:translateY(40px) scale(.98);
            will-change:opacity,transform;
        }

        /* quand le bloc .spotlight devient visible */
        .spotlight.is-visible{
            animation: spotlightReveal .8s cubic-bezier(.22,.61,.36,1) forwards;
        }

        /* HEADER DU MODULE spotlight */
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

        .title-underline {
            width: 120px;
            height: 4px !important;
            background: #d4af37 !important;
            margin: 10px 0 0 0 !important; /* Marge supérieure réduite à 10px */
            position: relative;
            border-radius: 2px; /* Coins légèrement arrondis */
        }

        /* zone flèches + compteur */
        .head-right{
            display:flex;
        {{ ... }}
            margin-top:8px;
        }

        .arrow-btn{
            background: none;
            border: none;
            font-weight: 400;
            color: var(--accent);
            cursor: pointer;
            user-select: none;
            appearance: none;
            font-family: inherit;
            padding: 0;
            margin: 0;
            outline: none;
            -webkit-tap-highlight-color: transparent;
        }

        .arrow-btn:focus,
        .arrow-btn:active,
        .arrow-btn:hover {
            outline: none !important;
            box-shadow: none !important;
            border: none !important;
            background: none !important;
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

        /* CORPS DU MODULE spotlight */
        .spotlight-body{
            display:flex;
            flex-wrap:nowrap;
            align-items:stretch;
            margin-top:24px;
        }

        /* image gauche */
        .card-media{
            flex:1 1 auto;
            min-width:0;
            background:#000;
            position:relative;
            min-height:460px;

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

        /* panneau texte droite */
        .card-text{
            flex:0 0 420px;
            max-width:420px;
            background:var(--panel-bg);
            border:1px solid var(--panel-border);

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

        /* Spotlight responsive */
        @media(max-width:900px){
            .spotlight-body{
                flex-direction:column;
                border:1px solid var(--panel-border);
                border-radius:var(--radius);
                overflow:hidden;
            }

            .card-media{
                min-height:320px;
                width:100%;
                border-bottom:1px solid var(--panel-border);

                border-top-left-radius:0;
                border-bottom-left-radius:0;
            }

            .card-text{
                flex:unset;
                max-width:100%;
                border:0;
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
                font-size: 18px;
                border: none;
                outline: none;
                box-shadow: none;
            }
            .count{
                font-size:14px;
                min-width:auto;
            }
            .card-headline{
                font-size:20px;
            }
        }

        /* =========================
           BLOC RESTAURANT (SCROLL REVEAL + SHIMMER)
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

        /* état initial AVANT visibilité */
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

        /* quand .is-visible -> anim */
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

        /* bloc texte + shimmer */
        .hero-restaurant-text{
            position:relative;
            z-index:2;
            max-width:1200px;
            width:100%;
            padding:0 1rem;
            text-align:center;
            text-shadow:0 20px 40px rgba(0,0,0,.8);

            font-size:clamp(1.1rem,0.6vw + 1rem,2rem);
            line-height:1.4;
            font-weight:400;
            color:var(--txt-color);

            overflow:hidden; /* important pour couper le reflet */
        }

        /* Animation de luminosité supprimée */

        .hero-restaurant-text p {
            margin: 0.8em 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.7),
            0 4px 8px rgba(0, 0, 0, 0.5);
        }

        /* lignes cachées avant scroll */
        .reveal-line{
            opacity:0;
            transform:translateY(20px);
        }

        /* reveal progressif */
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

        .hero-restaurant-text .line-1 span{
            display:inline-block;
            padding-bottom:0.4rem;
            border-bottom:1px solid rgba(255,255,255,.9);
            white-space:nowrap;
        }

        /* =========================
           RESPONSIVE GLOBAL
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
           ACCESSIBILITÉ
        ==========================*/
        @media (prefers-reduced-motion: reduce){
            .site-header{
                transform:none !important;
                opacity:1 !important;
            }
            #brandFloat{
                display:none !important;
            }

            .hero-img{
                animation: none !important;
                transform: scale(1) !important;
                opacity: 1 !important;
            }

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

            .spotlight{
                opacity:1 !important;
                transform:none !important;
                animation:none !important;
            }

            /* Animation de luminosité supprimée */
        }
    </style>
</head>
<body>

<!-- Header -->
<!-- Menu latéral -->
<div class="sidebar" id="sidebar">
    <button class="menu-toggle" id="closeMenu" aria-label="Fermer le menu"><i class="fas fa-times"></i></button>
    <nav class="sidebar-nav">
        <a href="#">Accueil</a>
        <a href="#">Notre Carte</a>
        <a href="#">Notre Équipe</a>
        <a href="#">Galerie</a>
        <a href="#">Contact</a>
        <a href="#">Réserver</a>
    </nav>
</div>
<div class="overlay" id="overlay"></div>

<header class="site-header" id="siteHeader" aria-label="Navigation principale">
    <div class="header-inner">
        <button id="openMenu" aria-label="Ouvrir le menu"><span></span></button>
        <div aria-hidden="true"></div> <!-- slot central -->
        <nav class="nav">
            <div class="social-nav">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>
            <div class="main-nav">
                <a href="#">Réserver</a>
            </div>
        </nav>
    </div>
</header>

<!-- Cible finale CENTRÉE dans le header -->
<div id="headerAnchorProxy" class="brand-anchor-proxy" aria-hidden="true">Keyfet</div>

<!-- HERO PRINCIPAL (Keyfet / morph) -->
<section class="hero">
    <img class="hero-img" src="../assets/img/image.resto.jpg" alt="Visuel de collection" />
    <div class="hero-overlay">
        <h1 class="brand--hero" id="heroBrand" aria-hidden="true">Keyfet</h1>
        <p class="tagline" aria-hidden="true">New season • Timeless craftsmanship</p>
    </div>
</section>

<!-- Texte flottant UNIQUE qui bouge vers le header -->
<div id="brandFloat" class="brand--float">Keyfet</div>



<!-- BLOC SPOTLIGHT (COUPS DE PROJECTEUR) -->
<section class="spotlight" id="spotlight">
    <header class="spotlight-head">
        <div class="head-left">
            <p class="overline">Restaurant Keyfet</p>

            <div class="title-wrap">
                <h2 class="main-title">Notre histoire</h2>
                <div class="title-underline"></div>
            </div>
        </div>

        <div class="head-right">
            <button class="arrow-btn prev" id="prevBtn" aria-label="Précédent">←</button>
            <span class="count" id="slideCounter">01/04</span>
            <button class="arrow-btn next" id="nextBtn" aria-label="Suivant">→</button>
        </div>
    </header>

    <article class="spotlight-body">
        <figure class="card-media">
            <img
                    id="spotlightImg"
                    src=""
                    alt=""
            />
        </figure>

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

<!-- BLOC RESTAURANT (apparition au scroll + reflet) -->
<section class="hero-restaurant" id="heroRestaurant">
    <img
            class="hero-restaurant-bg"
            src="https://restodeparis.com/wp-content/uploads/2022/09/restaurant-gastronomique-paris-sphere.jpg"
            alt="Intérieur du restaurant, ambiance chaleureuse, tables dressées"
    />

    <div class="hero-restaurant-text">
        <p class="line-1 reveal-line">
            <span>Chaque espace du restaurant a son style et sa signature&nbsp;:</span>
        </p>

        <p class="line-2 reveal-line">
            L’îlot central avec ses banquettes sur mesure et son éclairage<br/>
            surprenant…
        </p>

        <p class="line-3 reveal-line">
            ou le salon à l’entrée avec son escalier sans issue énigmatique,
        </p>

        <p class="line-4 reveal-line">
            ou encore le superbe bar émeraude illuminé par des sphère brillantes.
        </p>

        <!-- Bouton de réservation -->
        <div class="reservation-button-container" style="margin-top: 40px; text-align: center; position: relative; z-index: 2;">
            <a href="#reservation" class="reservation-button" style="display: inline-flex; align-items: center; justify-content: center; padding: 15px 35px; background: linear-gradient(45deg, #d4af37, #f1c40f); color: #ffffff; font-size: 1.1rem; font-weight: 600; text-decoration: none; border-radius: 50px; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); position: relative; overflow: hidden; z-index: 1;">
                <span>RÉSERVER</span>
                <i class="fas fa-arrow-right" style="margin-left: 10px; transition: transform 0.3s ease; color: #ffffff;"></i>
            </a>
        </div>
    </div>
</section>

<style>
    .reservation-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 15px 35px;
        background: linear-gradient(45deg, #d4af37, #f1c40f);
        color: #1a1a1a;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .reservation-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #f1c40f, #d4af37);
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .reservation-button:hover::before {
        opacity: 1;
    }

    .reservation-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
    }

    .reservation-button:active {
        transform: translateY(1px);
        box-shadow: 0 2px 10px rgba(212, 175, 55, 0.4);
    }

    .reservation-button i {
        margin-left: 10px;
        transition: transform 0.3s ease;
    }

    .reservation-button:hover i {
        transform: translateX(5px);
    }

    @media (max-width: 768px) {
        .reservation-button {
            padding: 12px 30px;
            font-size: 1rem;
        }
    }
</style>

<script>
    // Effet de parallaxe pour l'image d'arrière-plan
    document.addEventListener('DOMContentLoaded', function() {
        // Parallaxe pour l'image d'arrière-plan
        const heroBg = document.querySelector('.hero-restaurant-bg');
        let mouseX = 0, mouseY = 0;
        let targetX = 0, targetY = 0;

        if (heroBg) {
            document.addEventListener('mousemove', (e) => {
                // Calculer la position de la souris en pourcentage
                mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
                mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
            });

            // Animation fluide avec requestAnimationFrame
            function animate() {
                // Lissage du mouvement
                targetX = mouseX * 30; // Ajustez ce multiplicateur pour contrôler l'intensité du déplacement
                targetY = mouseY * 30;

                // Appliquer la transformation avec un effet de ressort pour plus de douceur
                const dx = (targetX - parseFloat(heroBg.style.getPropertyValue('--translate-x') || 0)) * 0.1;
                const dy = (targetY - parseFloat(heroBg.style.getPropertyValue('--translate-y') || 0)) * 0.1;

                const newX = (parseFloat(heroBg.style.getPropertyValue('--translate-x') || 0) + dx).toFixed(2);
                const newY = (parseFloat(heroBg.style.getPropertyValue('--translate-y') || 0) + dy).toFixed(2);

                heroBg.style.setProperty('--translate-x', newX + 'px');
                heroBg.style.setProperty('--translate-y', newY + 'px');

                // Appliquer la transformation
                heroBg.style.transform = `translate(calc(-50% + var(--translate-x, 0px)), calc(-50% + var(--translate-y, 0px))) scale(1.1)`;

                requestAnimationFrame(animate);
            }

            // Démarrer l'animation
            requestAnimationFrame(animate);

            // Effet de profondeur au survol
            heroBg.addEventListener('mousemove', (e) => {
                const rect = heroBg.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // Effet de profondeur 3D
                heroBg.style.transformOrigin = `${x}px ${y}px`;
                heroBg.style.transform = `translate(calc(-50% + var(--translate-x, 0px)), calc(-50% + var(--translate-y, 0px))) scale(1.05)`;
            });

            heroBg.addEventListener('mouseleave', () => {
                heroBg.style.transform = `translate(calc(-50% + var(--translate-x, 0px)), calc(-50% + var(--translate-y, 0px))) scale(1.1)`;
                heroBg.style.transformOrigin = 'center center';
            });
        }
    });

    // Effet de parallaxe et zoom sur la vidéo
    document.addEventListener('DOMContentLoaded', function() {
        // Animation d'apparition des sections au défilement
        function animateOnScroll() {
            const sections = document.querySelectorAll('.carte-section, .videos-section');

            sections.forEach(section => {
                const sectionTop = section.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (sectionTop < windowHeight - 100) {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';

                    // Animation spécifique pour les cartes de la section vidéo
                    if (section.classList.contains('videos-section')) {
                        const cards = section.querySelectorAll('.video-card');
                        cards.forEach((card, index) => {
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0) scale(1)';
                            }, index * 150); // Délai progressif entre chaque carte
                        });
                    }
                }
            });
        }

        // Initialisation des styles pour l'animation
        function initAnimations() {
            // Section Notre Carte
            const carteSection = document.querySelector('.carte-section');
            if (carteSection) {
                carteSection.style.opacity = '0';
                carteSection.style.transform = 'translateY(50px)';
                carteSection.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            }

            // Section Découvrez Notre Univers
            const videosSection = document.querySelector('.videos-section');
            if (videosSection) {
                videosSection.style.opacity = '0';
                videosSection.style.transform = 'translateY(50px)';
                videosSection.style.transition = 'opacity 0.8s ease 0.3s, transform 0.8s ease 0.3s';

                // Animation des cartes vidéo
                const videoCards = videosSection.querySelectorAll('.video-card');
                videoCards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px) scale(0.95)';
                    card.style.transition = `opacity 0.5s ease ${0.5 + (index * 0.1)}s, transform 0.5s ease ${0.5 + (index * 0.1)}s`;
                });
            }

            // Démarrer l'animation après un court délai
            setTimeout(animateOnScroll, 500);
        }

        // Démarrer les animations au chargement
        window.addEventListener('load', initAnimations);
        window.addEventListener('scroll', animateOnScroll);

        const video = document.querySelector('.carte-video video');
        const content = document.querySelector('.carte-content');
        const section = document.querySelector('.carte-section');

        // Démarrer la lecture de la vidéo (nécessite une interaction utilisateur sur certains navigateurs)
        if (video) {
            const playPromise = video.play();
            if (playPromise !== undefined) {
                playPromise.catch(error => {
                    // La lecture automatique a échoué, on gère l'erreur en silence
                    // La vidéo se jouera au premier clic utilisateur
                });
            }
        }

        function updateParallax() {
            if (window.innerWidth > 1024) { // Désactiver sur mobile
                const scrollPosition = window.scrollY;
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                const windowHeight = window.innerHeight;

                // Calculer la position de défilement relative à la section
                const scrollPercent = (scrollPosition - sectionTop + windowHeight) / (sectionHeight + windowHeight);

                // Limiter la valeur entre 0 et 1
                const scale = 1 + Math.min(Math.max(scrollPercent * 0.5, 0), 0.5);

                // Appliquer la transformation à la vidéo
                if (video) {
                    video.style.transform = `translate(-50%, -50%) scale(${scale})`;
                }

                // Ajuster l'opacité du contenu
                content.style.opacity = 1 - (scrollPercent * 0.2);
            }
        }

        // Désactiver l'effet sur mobile
        function handleResize() {
            if (window.innerWidth <= 1024) {
                if (video) {
                    video.style.transform = 'translate(-50%, -50%) scale(1)';
                }
                if (content) {
                    content.style.opacity = '1';
                }
            }
        }

        window.addEventListener('scroll', updateParallax);
        window.addEventListener('resize', handleResize);

        // Initialiser
        updateParallax();
        handleResize();
    });

    // Gestion du menu latéral
    document.addEventListener('DOMContentLoaded', function() {
        const openMenu = document.getElementById('openMenu');
        const closeMenu = document.getElementById('closeMenu');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMenu() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        openMenu.addEventListener('click', toggleMenu);
        closeMenu.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // Fermer le menu lors du redimensionnement de la fenêtre
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }
        });
    });

    /* ===========================
       SLIDER "COUPS DE PROJECTEUR"
    ============================ */

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

    const imgEl = document.getElementById("spotlightImg");
    const kickerEl = document.getElementById("spotlightKicker");
    const headlineEl = document.getElementById("spotlightHeadline");
    const descEl = document.getElementById("spotlightDesc");
    const linkEl = document.getElementById("spotlightLink");
    const counterEl = document.getElementById("slideCounter");

    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    let currentIndex = 0;

    function pad2(n){
        const human = n + 1;
        return human < 10 ? "0" + human : "" + human;
    }
    function padTotal(n){
        return n < 10 ? "0" + n : "" + n;
    }

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

    // premier affichage du slider
    renderSlide();


    /* ===========================
       SCROLL MORPH DU TITRE "KEYFET"
    ============================ */

    const TRIGGER = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--trigger')) || 220;
    const easeOutCubic = t => 1 - Math.pow(1 - t, 3);

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

    // rAF scroll loop pour morph
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


    /* ===========================
       APPARITION AU SCROLL
       - spotlight (coup de projecteur)
       - heroRestaurant (bloc resto)
    ============================ */

    // bloc spotlight
    const spotlightSection = document.getElementById('spotlight');
    let spotlightShown = false;

    // bloc resto
    const restoSection = document.getElementById('heroRestaurant');
    let restoShown = false;

    if ('IntersectionObserver' in window){
        const obs = new IntersectionObserver((entries)=>{
            for (const entry of entries){
                // spotlight reveal
                if (entry.target === spotlightSection && entry.isIntersecting && !spotlightShown){
                    spotlightSection.classList.add('is-visible');
                    spotlightShown = true;
                }
                // restaurant reveal
                if (entry.target === restoSection && entry.isIntersecting && !restoShown){
                    restoSection.classList.add('is-visible'); // déclenche zoom/fade + fadeUp lignes
                    restoShown = true;
                }
            }
        },{
            threshold: 0.3 // ~30% visible
        });

        if (spotlightSection) obs.observe(spotlightSection);
        if (restoSection)     obs.observe(restoSection);

    } else {
        // fallback vieux nav
        if (spotlightSection){
            spotlightSection.classList.add('is-visible');
        }
        if (restoSection){
            restoSection.classList.add('is-visible');
        }
    }


    /* ===========================
       INIT GLOBALE
    ============================ */
    // Effet de dézoom au défilement
    document.addEventListener('DOMContentLoaded', function() {
        const image = document.querySelector('.carte-image img');
        const section = document.querySelector('.carte-section');

        function updateZoom() {
            if (window.innerWidth > 1024) { // Désactiver sur mobile
                const scrollPosition = window.scrollY;
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                const windowHeight = window.innerHeight;

                // Calculer la position de défilement relative à la section
                let scrollPercent = (scrollPosition - sectionTop + windowHeight) / (sectionHeight + windowHeight);

                // Ajuster la courbe pour un effet plus progressif
                scrollPercent = Math.min(Math.max(scrollPercent, 0), 1);

                // Appliquer une courbe d'accélération pour un effet plus naturel
                const easeOutCubic = t => 1 - Math.pow(1 - t, 3);
                const easedScroll = easeOutCubic(scrollPercent);

                // Échelle variant de 1.3 (zoomé) à 1.0 (dézoomé)
                const scale = 1.3 - (easedScroll * 0.3);

                // Appliquer la transformation à l'image
                if (image) {
                    image.style.transform = `scale(${scale})`;
                }
            }
        }

        // Désactiver l'effet sur mobile
        function handleResize() {
            if (window.innerWidth <= 1024 && image) {
                image.style.transform = 'scale(1)';
            }
        }

        window.addEventListener('scroll', updateZoom);
        window.addEventListener('resize', handleResize);

        // Initialiser
        updateZoom();
        handleResize();
    });

    window.addEventListener('load',  ()=>{ measure(); updateOnScroll(); });
    window.addEventListener('resize', reflow);
    window.addEventListener('orientationchange', reflow);
    window.addEventListener('scroll', onScroll, { passive:true });

    if (document.fonts && document.fonts.ready){
        document.fonts.ready.then(reflow);
    }

    // La gestion des vidéos a été déplacée plus bas dans le fichier pour éviter les conflits

</script>

<!-- SECTION NOTRE CARTE -->
<section class="carte-section" id="notre-carte">
    <div class="carte-container">
        <div class="carte-scroll-container">
            <div class="carte-video-wrapper">
                <div class="carte-video">
                    <div class="carte-image">
                        <img src="https://i.pinimg.com/736x/6c/44/db/6c44db234b3964bf5d38c623c455107d.jpg" alt="Notre carte">
                    </div>
                    <div class="video-overlay"></div>
                </div>
            </div>
            <div class="carte-content">
                <div class="title-wrap">
                    <h2 class="main-title">Notre Carte</h2>
                    <div class="title-underline"></div>
                </div>

                <div class="carte-description">
                    <p>Découvrez notre sélection de plats préparés avec des ingrédients frais et de saison. Notre chef vous propose une cuisine raffinée alliant tradition et créativité.</p>
                </div>

                <div class="carte-menus">
                    <div class="menu-category">
                        <h3>Entrées</h3>
                        <ul>
                            <li>Salade de chèvre chaud - <span>12€</span></li>
                            <li>Terrine de foie gras - <span>18€</span></li>
                            <li>Carpaccio de Saint-Jacques - <span>16€</span></li>
                        </ul>
                    </div>

                    <div class="menu-category">
                        <h3>Plats</h3>
                        <ul>
                            <li>Filet de bar rôti - <span>28€</span></li>
                            <li>Carré d'agneau - <span>32€</span></li>
                            <li>Risotto aux cèpes - <span>24€</span></li>
                        </ul>
                    </div>

                    <div class="menu-category">
                        <h3>Desserts</h3>
                        <ul>
                            <li>Fondant au chocolat - <span>10€</span></li>
                            <li>Tarte tatin - <span>9€</span></li>
                            <li>Assiette de fromages - <span>14€</span></li>
                        </ul>
                    </div>
                </div>

                <div class="carte-cta">
                    <a href="#reservation" class="btn-reserver">VOIR LA CARTE</a>
                </div>
            </div>
        </div>
</section>

<!-- Séparateur élégant entre les sections -->
<div class="section-separator">
    <div class="separator-line"></div>
</div>

<!-- SECTION VIDEOS -->
<section class="videos-section">
    <div class="videos-container" style="text-align: center;">
        <h2 class="section-title" style="display: inline-block; text-align: center;">DÉCOUVREZ NOTRE UNIVERS</h2>
        <div class="videos-grid">
            <div class="video-card">
                <div class="video-wrapper">
                    <video class="video-preview" loop muted playsinline>
                        <source src="../assets/img/From KlickPin CF Pin by The Pretty Girl Bible _ Femini on Facebook Reels _ Snap food Food vids Fire food.mp4" type="video/mp4">
                    </video>
                    <div class="play-button">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <h3>Nos Services</h3>
                <p>Un service attentionné pour une expérience gastronomique inoubliable</p>
            </div>

            <div class="video-card">
                <div class="video-wrapper">
                    <video class="video-preview" loop muted playsinline>
                        <source src="../assets/img/From KlickPin CF Canadian Heritage Rib-Eye [Vídeo] _ Receitas Açougue.mp4" type="video/mp4">
                    </video>
                    <div class="play-button">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <h3>Préparation des Plats</h3>
                <p>L'art culinaire à son apogée avec nos chefs étoilés</p>
            </div>

            <div class="video-card">
                <div class="video-wrapper">
                    <video class="video-preview" loop muted playsinline>
                        <source src="./assets/img/From KlickPin CF Shogun Experience in 2025 _ Modern restaurant design Japanese restaurant design Restaurant exterior design - Copie.mp4" type="video/mp4">
                    </video>
                    <div class="play-button">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <h3>Espace Dégustation</h3>
                <p>Une ambiance raffinée pour une expérience sensorielle unique</p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Styles pour les animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animation pour l'apparition séquentielle des vidéos */
    .video-card {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
    }

    /* Délais d'animation pour chaque carte vidéo */
    .video-card:nth-child(1) {
        animation-delay: 0.3s;
    }

    .video-card:nth-child(2) {
        animation-delay: 0.6s;
    }

    .video-card:nth-child(3) {
        animation-delay: 0.9s;
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Style du séparateur de sections */
    .section-separator {
        position: relative;
        height: 10px;
        background: transparent;
        margin: 0;
        padding: 0;
    }

    .separator-line {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 10px;
        background: linear-gradient(90deg, #8a7a54, #c0a86e, #8a7a54);
        opacity: 0.2;
    }

    .histoire-section {
        background: linear-gradient(135deg, #f9f8f5 0%, #f0ede7 100%);
        border-left: 1px solid rgba(0, 0, 0, 0.05);
        border-right: 1px solid rgba(0, 0, 0, 0.05);
        background-image: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1));
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1555244162-803834f70033?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        opacity: 0.08;
        z-index: 0;
    }

    .videos-container {
        position: relative;
        z-index: 1;
    }

    .videos-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .section-title {
        text-align: center;
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(26px, 1vw + 22px, 36px);
        margin: 0 auto 60px;
        color: #222;
        font-weight: 400;
        position: relative;
        line-height: 1.3;
        display: inline-block;
    }

    .videos-container .section-title {
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .videos-container .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        max-width: 800px;
        height: 3px; /* Épaisseur réduite à 3px */
        background: #d4af37;
        border-radius: 1.5px; /* Rayon de bordure proportionnel réduit */
    }

    .videos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 50px;
    }

    @media (max-width: 1200px) {
        .videos-grid {
            grid-template-columns: repeat(3, 1fr);
            padding: 0 20px;
        }
    }

    @media (max-width: 1024px) {
        .videos-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .videos-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .videos-grid {
            grid-template-columns: 1fr;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    .video-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.5s ease;
        opacity: 0;
        transform: translateY(30px) scale(0.95);
        will-change: transform, opacity;
    }

    .video-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .video-wrapper {
        position: relative;
        width: 100%;
        padding-bottom: 100%; /* Format carré */
        background: #000;
        cursor: pointer;
    }

    .video-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.9;
        transition: opacity 0.3s ease;
    }

    .video-card:hover .video-preview {
        opacity: 0.7;
    }

    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }

    .play-button i {
        color: white;
        font-size: 24px;
        margin-left: 5px;
    }

    .video-card:hover .play-button {
        background: rgba(212, 175, 55, 0.8);
        transform: translate(-50%, -50%) scale(1.1);
    }

    .video-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .video-card h3 {
        padding: 20px 20px 25px;
        font-family: "Playfair Display", Georgia, serif;
        font-size: 1.5rem;
        color: #222;
        margin: 0 20px 15px;
        font-weight: 500;
        letter-spacing: 0.5px;
        position: relative;
        display: inline-block;
    }

    .video-card h3::after {
        content: '';
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 2px;
        background: #d4af37;
        transition: width 0.3s ease;
    }

    .video-card:hover h3::after {
        width: 80px;
    }

    .video-card p {
        padding: 0 25px 25px;
        color: #666;
        line-height: 1.6;
        margin: 0;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        font-weight: 300;
        letter-spacing: 0.3px;
        text-align: center;
        max-width: 90%;
    }

    @media (max-width: 992px) {
        .videos-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .videos-grid {
            grid-template-columns: 1fr;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .section-title {
            font-size: 2rem;
            margin-bottom: 40px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des vidéos
        const videoWrappers = document.querySelectorAll('.video-wrapper');

        // Configuration initiale des vidéos
        function setupVideos() {
            videoWrappers.forEach((wrapper, index) => {
                const video = wrapper.querySelector('.video-preview');
                const playButton = wrapper.querySelector('.play-button');

                if (!video) return;

                // Configuration de base des vidéos
                video.muted = true;
                video.playsInline = true;
                video.loop = true;

                // Démarrer la lecture avec un léger délai
                setTimeout(() => {
                    const playPromise = video.play();

                    if (playPromise !== undefined) {
                        playPromise.then(() => {
                            // Lecture démarrée avec succès
                            if (playButton) playButton.style.opacity = '0';
                        }).catch(error => {
                            // Échec de la lecture automatique
                            console.log('Lecture automatique bloquée :', error);
                            if (playButton) playButton.style.opacity = '1';
                        });
                    }
                }, 300 * index);

                // Gestion du clic sur la vidéo
                if (wrapper) {
                    wrapper.addEventListener('click', function() {
                        if (video.paused) {
                            video.play().then(() => {
                                if (playButton) playButton.style.opacity = '0';
                            });
                        } else {
                            video.pause();
                            if (playButton) playButton.style.opacity = '1';
                        }
                    });
                }

                // Gestion des événements de lecture
                if (video) {
                    video.addEventListener('play', function() {
                        if (playButton) playButton.style.opacity = '0';
                    });

                    video.addEventListener('pause', function() {
                        if (playButton) playButton.style.opacity = '1';
                    });

                    video.addEventListener('ended', function() {
                        video.currentTime = 0;
                        video.play().catch(e => console.log('Erreur de lecture :', e));
                    });
                }
            });
        }

        // Démarrer la configuration des vidéos
        setupVideos();

        // Gestionnaire d'interaction utilisateur pour débloquer la lecture
        function handleUserInteraction() {
            videoWrappers.forEach(wrapper => {
                const video = wrapper.querySelector('.video-preview');
                if (video && video.paused) {
                    video.play().catch(e => console.log('Erreur de lecture :', e));
                }
            });
        }

        // Ajouter les écouteurs d'événements pour l'interaction utilisateur
        document.addEventListener('click', handleUserInteraction);
        document.addEventListener('touchstart', handleUserInteraction);
    });
</script>

<style>
    /* Animation d'apparition du footer */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .footer-section {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .footer-section:nth-child(1) { animation-delay: 0.1s; }
    .footer-section:nth-child(2) { animation-delay: 0.2s; }
    .footer-section:nth-child(3) { animation-delay: 0.3s; }

    /* Effet de fond animé */
    .site-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
        pointer-events: none;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 30px;
        }

        .footer-section h3::after,
        .footer-section h4::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-section p {
            justify-content: center;
        }

        .social-links {
            justify-content: center;
        }

        .legal-links {
            flex-direction: column;
            gap: 5px;
        }

        .separator {
            display: none;
        }
    }
</style>

<script>
    // Animation d'apparition du footer au défilement
    document.addEventListener('DOMContentLoaded', function() {
        const footer = document.querySelector('.site-footer');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    footer.style.opacity = '1';
                }
            });
        }, { threshold: 0.1 });

        if (footer) observer.observe(footer);
    });
</script>

<!-- Section Réservation -->
<style>
    /* Styles pour la section réservation */
    .reservation-section {
        padding: 100px 0;
        background:
                linear-gradient(135deg, #f8f5f0 0%, #f1e8d9 100%),
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23d4af37' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        position: relative;
        overflow: hidden;
        background-blend-mode: overlay;
    }

    .reservation-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 10px;
        background: linear-gradient(90deg, #8a7a54, #c0a86e, #8a7a54);
        opacity: 0.2;
    }

    .reservation-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        position: relative;
        z-index: 1;
    }

    .section-header {
        text-align: center;
        margin-bottom: 40px; /* Réduit la marge inférieure */
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        color: #2c2c2c;
        margin: 0 auto 5px; /* Marge inférieure réduite */
        font-weight: 500;
        letter-spacing: 0.5px;
        position: relative;
        display: inline-block; /* Revenu à inline-block pour que le trait s'adapte au texte */
        padding-bottom: 5px; /* Espace réduit sous le titre */
        text-align: center;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%; /* Centre le point de départ du trait */
        transform: translateX(-50%); /* Centre le trait par rapport au texte */
        width: 120px; /* Largeur fixe du trait */
        height: 4px;
        background: #d4af37;
    }

    .title-underline {
        width: 120px !important;
        height: 4px !important;
        background: #d4af37 !important;
        margin: 10px 0 0 0 !important; /* Marge supérieure réduite à 10px */
        position: relative;
        border-radius: 2px !important;
    }

    /* Suppression des ronds sur les traits de titre */
    .title-underline::after {
        display: none;
    }

    .reservation-content {
        display: flex;
        gap: 50px;
        margin-top: 40px;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease-out 0.3s forwards;
    }

    .reservation-form, .opening-hours {
        flex: 1;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
        padding: 40px;
    }

    .reservation-form:hover, .opening-hours:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }

    /* Styles pour la section vidéo */
    .videos-section {
        padding: 100px 0;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #f9f8f5 0%, #f0ede7 100%);
    }

    .videos-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1555244162-803834f70033?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        opacity: 0.08;
        z-index: 0;
    }

    .videos-container {
        position: relative;
        z-index: 1;
    }

    .reservation-form::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #8a7a54, #c0a86e);
    }

    .form-title {
        color: #2c2c2c;
        font-size: 28px;
        margin-bottom: 30px;
        font-family: 'Playfair Display', serif;
        font-weight: 500;
        position: relative;
        padding-bottom: 15px;
    }

    .form-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: #8a7a54;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row .form-group {
        flex: 1;
        margin-bottom: 0;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="date"],
    input[type="time"],
    select,
    textarea {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 15px;
        color: #333;
        background-color: #fafafa;
        transition: all 0.3s ease;
        font-family: 'Libre Baskerville', serif;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    input[type="date"]:focus,
    input[type="time"]:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #8a7a54;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(138, 122, 84, 0.1);
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    .btn-submit {
        background: linear-gradient(135deg, #8a7a54 0%, #a08a5a 100%);
        color: white;
        border: none;
        padding: 16px 30px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        width: 100%;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: 'Libre Baskerville', serif;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #a08a5a 0%, #8a7a54 100%);
        transition: all 0.5s ease;
        z-index: -1;
    }

    .btn-submit:hover::before {
        left: 0;
    }

    .opening-hours {
        padding: 50px;
        background: #fff;
        position: relative;
    }

    .opening-hours::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(to bottom, #8a7a54, #c0a86e);
    }

    .hours-title {
        color: #2c2c2c;
        font-size: 28px;
        margin-bottom: 30px;
        font-family: 'Playfair Display', serif;
        font-weight: 500;
        position: relative;
        padding-bottom: 15px;
    }

    .hours-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: #8a7a54;
    }

    .hours-container {
        margin-bottom: 0;
    }

    .hours-item {
        display: flex;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .hours-item:hover {
        background-color: #fcfaf7;
        padding-left: 10px;
    }

    .day {
        font-weight: 500;
        color: #333;
        font-size: 15px;
    }

    .hours {
        color: #666;
        font-size: 15px;
        font-family: 'Libre Baskerville', serif;
    }

    .contact-info {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #f0f0f0;
    }

    .contact-title {
        font-size: 22px;
        margin-bottom: 25px;
        color: #2c2c2c;
        font-family: 'Playfair Display', serif;
        font-weight: 500;
        position: relative;
        padding-bottom: 10px;
    }

    .contact-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background: #8a7a54;
    }

    .contact-info p {
        margin-bottom: 15px;
        color: #555;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 15px;
        line-height: 1.6;
    }

    .contact-info i {
        color: #8a7a54;
        width: 24px;
        text-align: center;
        font-size: 16px;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 992px) {
        .reservation-content {
            flex-direction: column;
            gap: 30px;
        }

        .reservation-form, .opening-hours {
            width: 100%;
        }

        .form-row {
            flex-direction: column;
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .section-title {
            font-size: 36px;
        }

        .reservation-form, .opening-hours {
            padding: 30px 25px;
        }

        .form-title, .hours-title {
            font-size: 24px;
        }
    }

    @media (max-width: 480px) {
        .section-title {
            font-size: 30px;
        }

        .reservation-section {
            padding: 70px 0;
        }
    }
</style>

<section class="reservation-section" id="reservation">
    <div class="reservation-container">
        <div class="section-header">
            <h2 class="section-title">Réservation</h2>
        </div>

        <div class="reservation-content">
            <!-- Colonne de gauche : Formulaire de réservation -->
            <div class="reservation-form">
                <h3 class="form-title">Réservez votre table</h3>
                <form id="bookingForm" class="booking-form">
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" required>
                        </div>

                        <div class="form-group">
                            <label for="time">Heure</label>
                            <input type="time" id="time" name="time" required>
                        </div>

                        <div class="form-group">
                            <label for="guests">Personnes</label>
                            <select id="guests" name="guests" required>
                                <option value="1">1 personne</option>
                                <option value="2" selected>2 personnes</option>
                                <option value="3">3 personnes</option>
                                <option value="4">4 personnes</option>
                                <option value="5">5 personnes</option>
                                <option value="6">6 personnes</option>
                                <option value="7">7 personnes</option>
                                <option value="8">8 personnes</option>
                                <option value="9">9 personnes</option>
                                <option value="10">10+ personnes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Demandes spéciales (optionnel)</label>
                        <textarea id="message" name="message" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Réserver une table</button>
                </form>
            </div>

            <!-- Colonne de droite : Horaires -->
            <div class="opening-hours">
                <h3 class="hours-title">Nos horaires</h3>
                <div class="hours-container">
                    <div class="hours-item">
                        <span class="day">Lundi</span>
                        <span class="hours">11h30 - 14h30 • 19h00 - 23h00</span>
                    </div>
                    <div class="hours-item">
                        <span class="day">Mardi</span>
                        <span class="hours">11h30 - 14h30 • 19h00 - 23h00</span>
                    </div>
                    <div class="hours-item">
                        <span class="day">Mercredi</span>
                        <span class="hours">11h30 - 14h30 • 19h00 - 23h00</span>
                    </div>
                    <div class="hours-item">
                        <span class="day">Jeudi</span>
                        <span class="hours">11h30 - 14h30 • 19h00 - 23h00</span>
                    </div>
                    <div class="hours-item">
                        <span class="day">Vendredi</span>
                        <span class="hours">11h30 - 14h30 • 19h00 - 23h30</span>
                    </div>
                    <div class="hours-item">
                        <span class="day">Samedi</span>
                        <span class="hours">12h00 - 15h00 • 19h00 - 23h30</span>
                    </div>
                    <div class="hours-item">
                        <span class="day">Dimanche</span>
                        <span class="hours">12h00 - 15h00 • 19h00 - 22h30</span>
                    </div>
                </div>

                <div class="contact-info">
                    <h4 class="contact-title">Contact</h4>
                    <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
                    <p><i class="fas fa-envelope"></i> contact@keyfet.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Rue du Restaurant, 75000 Paris</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Keyf-et</h3>
            <p>Une expérience culinaire unique où chaque plat raconte une histoire.</p>
            <div class="social-links">
                <a href="#" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" class="social-icon" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>

        <div class="footer-section">
            <h4>Horaires</h4>
            <p><i class="far fa-clock"></i> Lundi - Vendredi: 12h - 15h, 19h - 23h</p>
            <p><i class="far fa-clock"></i> Samedi - Dimanche: 12h - 23h</p>
            <p><i class="fas fa-utensils"></i> Service continu</p>
        </div>

        <div class="footer-section">
            <h4>Contact</h4>

            <p><i class="fas fa-map-marker-alt"></i> 123 Rue du Restaurant, 75000 Paris</p>
            <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
            <p><i class="fas fa-envelope"></i> contact@keyf-et.com</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 Keyf-et. Tous droits réservés.</p>
        <div class="legal-links">
            <a href="#" class="legal-link">Mentions légales</a>
            <span class="separator">|</span>
            <a href="#" class="legal-link">Politique de confidentialité</a>
            <span class="separator">|</span>
            <a href="#" class="legal-link">CGV</a>
        </div>
    </div>
</footer>

<style>
    /* Footer Styles */
    .site-footer {
        background-color: #1a1a1a;
        color: #ffffff;
        padding: 60px 0 0;
        font-family: 'Poppins', sans-serif;
        position: relative;
        overflow: hidden;
        opacity: 0;
        transition: opacity 0.8s ease;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    .footer-section h3, .footer-section h4 {
        color: #d4af37;
        margin: 0 0 15px 0;
        padding: 0;
        font-size: 1.4rem;
        position: relative;
        display: block;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-align: left;
        width: 100%;
    }

    .footer-section h3::after, .footer-section h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -8px;
        width: 50px;
        height: 2px;
        background: #d4af37;
        transition: width 0.3s ease;
    }

    .footer-section h3::after {
        left: 0;
        transform: none;
        bottom: -5px;
    }

    .footer-section:hover h3::after,
    .footer-section:hover h4::after {
        width: 70px;
    }
    {{ ... }}
    width: 20px;
    text-align: center;
    }

    .social-links {
        margin: 20px 0 0 0;
        padding: 0;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-items: center;
        gap: 12px;
        white-space: nowrap;
        overflow: visible;
        width: 100%;
    }

    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        width: 38px;
        height: 38px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        color: #ffffff;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 16px;
        text-decoration: none;
        flex-shrink: 0;
    }

    .social-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    }

    /* Couleurs spécifiques pour chaque réseau social */
    .social-icon[aria-label="Facebook"]:hover {
        background: #3b5998;
    }
    .social-icon[aria-label="Instagram"]:hover {
        background: #e1306c;
    }
    .social-icon[aria-label="YouTube"]:hover {
        background: #ff0000;
    }
    .social-icon[aria-label="TikTok"]:hover {
        background: #000000;
    }
    .social-icon[aria-label="TripAdvisor"]:hover {
        background: #34e0a1;
    }
    }

    .footer-bottom {
        margin-top: 60px;
        padding: 20px 0;
        background: rgba(0, 0, 0, 0.3);
    {{ ... }}
        position: relative;
    }

    .footer-bottom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    }

    .footer-bottom p {
        color: #b3b3b3;
        margin: 0 0 10px;
        font-size: 0.9rem;
    }

    .legal-links {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 5px;
    }

    .legal-link {
        color: #b3b3b3;
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.85rem;
        padding: 0 10px;
        position: relative;
    }

    .legal-link:hover {
        color: #d4af37;
    }

    .separator {
        color: #666;
        user-select: none;
    }

    /* Animation d'apparition */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .footer-section {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .footer-section:nth-child(1) { animation-delay: 0.1s; }
    .footer-section:nth-child(2) { animation-delay: 0.2s; }
    .footer-section:nth-child(3) { animation-delay: 0.3s; }

    /* Effet de fond animé */
    .site-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
        pointer-events: none;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 30px;
        }

        .footer-section h3::after,
        .footer-section h4::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-section p {
            justify-content: center;
        }

        .social-links {
            justify-content: center;
        }

        .legal-links {
            flex-direction: column;
            gap: 5px;
        }

        .separator {
            display: none;
        }
    }
</style>

<script>
    // Animation d'apparition du footer
    document.addEventListener('DOMContentLoaded', function() {
        const footer = document.querySelector('.site-footer');
        if (footer) {
            // Faire apparaître le footer après un court délai
            setTimeout(() => {
                footer.style.opacity = '1';
            }, 500);

            // Animation au scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        footer.style.opacity = '1';
                        // Animation des sections du footer
                        const sections = footer.querySelectorAll('.footer-section');
                        sections.forEach((section, index) => {
                            setTimeout(() => {
                                section.style.opacity = '1';
                                section.style.transform = 'translateY(0)';
                            }, 100 * index);
                        });
                    }
                });
            }, { threshold: 0.1 });

            observer.observe(footer);
        }
    });
</script>
