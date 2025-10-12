<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) : 'Fox24Coin Blog' ?></title>
    
    <meta name="description" content="<?= isset($page_description) ? htmlspecialchars($page_description) : 'Wszystko o Fox24Coin - nowości, analizy i aktualizacje.' ?>">
    <link rel="canonical" href="https://fox24coin.com/<?= basename($_SERVER['PHP_SELF']) ?>">
    
    <link rel="icon" type="image/png" href="https://fox24coin.com/fox24.png">
    <link rel="apple-touch-icon" href="https://fox24coin.com/fox24.png">

    <link rel="alternate" type="application/rss+xml" title="Fox24Coin Blog RSS" href="/rss/" />

    <meta property="og:title" content="Fox24Coin Blog - News & Updates">
    <meta property="og:description" content="Latest news, insights, and updates from the Fox24Coin world.">
    <meta property="og:image" content="https://fox24coin.com/Gold-Reserve.png">
    <meta property="og:url" content="https://fox24coin.com/blog.php">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Fox24Coin Blog - News & Updates">
    <meta name="twitter:description" content="Latest news, insights, and updates from the Fox24Coin world.">
    <meta name="twitter:image" content="https://fox24coin.com/Gold-Reserve.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/style2.css">

    <?php // PUSTE - usunięto błędne `include 'includes/header.php';` ?>

<style>
/* ===================================
   1. ZUNIFIKOWANY SYSTEM ZMIENNYCH
=================================== */
:root {
    /* Kolory bazowe */
    --gold-color: #ffd700;
    --blue-color: #0d6efd;

    /* Kolory motywu ciemnego (domyślny) */
    --primary-bg: #121212;
    --secondary-bg: #1a1a1a;
    --card-bg: #222;
    --border-color: #333;
    --primary-text: #e0e0e0;
    --secondary-text: #c0c0c0;
    --heading-text: #ffffff;
    --primary-bg-rgb: 18, 18, 18;
    
    /* Zmienna dla koloru akcentu (domyślnie złoty) */
    --accent-color: var(--gold-color);
    --accent-color-rgb: 255, 215, 0;
}

/* Przełącznik na tryb jasny */
body.light-mode {
    --primary-bg: #f8f9fa;
    --secondary-bg: #ffffff;
    --card-bg: #ffffff;
    --border-color: #dee2e6;
    --primary-text: #343a40;
    --secondary-text: #6c757d;
    --heading-text: #212529;
    --primary-bg-rgb: 248, 249, 250;

    --accent-color: var(--blue-color);
    --accent-color-rgb: 13, 110, 253;
}

/* ===================================
   2. STYLE PODSTAWOWE
=================================== */
html { scroll-behavior: smooth; }
body {
    background-color: var(--primary-bg);
    color: var(--primary-text);
    font-family: 'Poppins', sans-serif;
    padding-top: 70px;
    transition: background-color 0.3s, color 0.3s;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
}
h1, h2, h3, h4, h5, h6 { 
    font-weight: 700; 
    color: var(--heading-text);
}
.section { padding: 80px 0; }
.bg-dark-2 { background-color: var(--secondary-bg); }
.text-gold, .text-accent { color: var(--accent-color) !important; }
.text-silver { color: var(--secondary-text) !important; }
.text-white-50 {
    color: rgba(255, 255, 255, 0.7) !important;
}
body.light-mode .text-white-50 {
    color: rgba(0, 0, 0, 0.5) !important;
}

/* ===================================
   3. KOMPONENTY
=================================== */
/* --- Nawigacja --- */
.navbar {
    background-color: rgba(var(--primary-bg-rgb), 0.85);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid transparent;
}
body.light-mode .navbar { border-bottom-color: var(--border-color); }
.navbar-brand { font-weight: 700; color: var(--primary-text); }
.nav-link { color: var(--secondary-text); }
.nav-link:hover, .nav-link.active { color: var(--accent-color); }
.dropdown-menu { background-color: var(--secondary-bg); border-color: var(--border-color); }
.dropdown-item { color: var(--primary-text); }
.dropdown-item:hover { background-color: var(--card-bg); color: var(--accent-color); }

/* --- Przyciski --- */
.btn-outline-accent { color: var(--accent-color); border-color: var(--accent-color); }
.btn-outline-accent:hover { color: var(--primary-bg); background-color: var(--accent-color); border-color: var(--accent-color); }
body.light-mode .btn-outline-accent:hover { color: #fff; }

.btn-accent { 
    background-color: var(--accent-color); 
    color: var(--primary-bg); 
    border: 1px solid var(--accent-color); 
    font-weight: 600; 
}
body.light-mode .btn-accent { color: #fff; }
.btn-accent:hover { 
    background-color: var(--accent-color); 
    border-color: var(--accent-color); 
    color: var(--primary-bg);
    filter: brightness(0.9);
}
body.light-mode .btn-accent:hover { color: #fff; }

.download-button {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    background-color: var(--accent-color);
    color: var(--primary-bg);
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 1rem 0;
    transition: background-color 0.3s ease, transform 0.2s ease;
}
body.light-mode .download-button { color: #fff; }
.download-button:hover {
    background-color: var(--accent-color);
    filter: brightness(0.9);
    color: var(--primary-bg);
    transform: translateY(-2px);
}
body.light-mode .download-button:hover { color: #fff; }
.download-button i {
    margin-right: 10px;
    font-size: 1.2em;
}

/* ===================================
   4. STRONA BLOGA I WPISÓW
=================================== */

/* --- Nagłówek 'Hero' (dla blog.php) --- */
.page-hero {
    background: linear-gradient(rgba(var(--primary-bg-rgb), 0.8), rgba(var(--primary-bg-rgb), 0.9)),
                url('https://static.wixstatic.com/media/e0bdea_f1b652d8dba0479c9ecc891cc1f9f0c2~mv2.jpg') center center no-repeat;
    background-size: cover;
    padding: 80px 0;
    display: flex;
    align-items: center;
    min-height: 50vh;
}
.page-hero h1 { font-size: 3.5rem; }

/* --- Karty Artykułów (dla blog.php) --- */
.post-card {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.post-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
.post-card-img { height: 200px; width: 100%; object-fit: cover; }
.post-card .card-body { padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1; }
.post-card .card-title a { color: var(--heading-text); text-decoration: none; transition: color 0.3s ease; }
.post-card .card-title a:hover { color: var(--accent-color); }
.post-card .card-text { color: var(--secondary-text); flex-grow: 1; }
.post-card .post-meta { font-size: 0.85rem; color: var(--secondary-text); opacity: 0.8; }
.btn-read-more { color: var(--accent-color); text-decoration: none; font-weight: 600; }

/* --- Pojedynczy Artykuł (dla post.php) --- */
.post-header .post-title { font-size: 3rem; color: var(--heading-text); }
.post-meta { color: var(--secondary-text); font-size: .9rem; }
.post-meta a { color: var(--accent-color); text-decoration: none; }
.post-content { font-size: 1.1rem; line-height: 1.8; color: var(--primary-text); }
.post-content h2, .post-content h3 { color: var(--heading-text); margin-top: 2.5rem; margin-bottom: 1.5rem; }
.post-content a { color: var(--accent-color); text-decoration: none; border-bottom: 1px dotted var(--accent-color); }
.post-content a:hover { color: var(--heading-text); border-bottom-style: solid; }
.post-content blockquote {
    border-left: 4px solid var(--accent-color);
    padding: 1rem 1.5rem;
    font-style: italic;
    color: var(--secondary-text);
    background-color: var(--card-bg);
    margin: 2rem 0;
}
.post-content img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 2.5rem auto;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
}
.post-tags .tag-badge {
    display: inline-block;
    padding: .4em .8em;
    background-color: var(--secondary-bg);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    color: var(--secondary-text);
    text-decoration: none;
    margin: 0.25rem;
    transition: background-color .3s, color .3s;
}
.post-tags .tag-badge:hover {
    background-color: var(--accent-color);
    color: var(--primary-bg);
    border-color: var(--accent-color);
}
body.light-mode .post-tags .tag-badge:hover { color: #fff; }

/* --- Przyciski Udostępniania --- */
.share-buttons { margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); }
.share-buttons h5 { margin-bottom: 1rem; color: var(--secondary-text); }
.share-button { display: inline-flex; align-items: center; justify-content: center; text-decoration: none; color: #fff; padding: 10px 18px; border-radius: 8px; margin-right: 10px; margin-bottom: 10px; font-size: 16px; transition: transform 0.2s ease, opacity 0.2s ease; }
.share-button:hover { transform: translateY(-2px); opacity: 0.9; color: #fff; }
.share-button i { margin-right: 8px; font-size: 20px; }

/* Kolory brandowe (pozostają bez zmian) */
.share-button.twitter { background-color: #1DA1F2; }
.share-button.facebook { background-color: #1877F2; }
.share-button.linkedin { background-color: #0A66C2; }
.share-button.pinterest { background-color: #E60023; }
.share-button.medium { background-color: #12100E; border: 1px solid #fff; }
.share-button.email { background-color: #888; }


/* --- Panel Boczny (Sidebar) --- */
.sidebar-widget { background-color: var(--card-bg); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color); margin-bottom: 2rem; }
.sidebar-widget .widget-title { color: var(--accent-color); font-weight: 600; border-bottom: 2px solid var(--border-color); padding-bottom: .5rem; margin-bottom: 1rem; }
.sidebar-widget ul { list-style-type: none; padding-left: 0; }
.sidebar-widget ul li a { color: var(--secondary-text); text-decoration: none; transition: color .3s ease; display: block; padding: .5rem 0; }
.sidebar-widget ul li a:hover { color: var(--accent-color); }

@media (min-width: 992px) {
    .main-content-col { border-right: 1px solid var(--border-color); padding-right: 2.5rem; }
    .sidebar-col { padding-left: 2.5rem; }
}

/* ===================================
   5. INNE ELEMENTY
=================================== */

/* --- Tabela Crypto --- */
.table-responsive-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; padding-bottom: 10px; margin: 2rem 0; }
.table-responsive-wrapper .crypto-table { margin: 0; }
.crypto-table { width: 100%; border-collapse: collapse; margin: 2rem 0; }
.crypto-table th, .crypto-table td { padding: 12px 15px; border-bottom: 1px solid var(--border-color); text-align: left; vertical-align: middle; }
.crypto-table th { color: var(--accent-color); font-weight: 600; }
.crypto-table td { color: var(--primary-text); }
.crypto-table .coin-info { display: flex; align-items: center; }
.crypto-table .coin-icon { width: 24px; height: 24px; margin-right: 10px; }
.price-up { color: #28a745 !important; }
.price-down { color: #dc3545 !important; }
.loading-row td { text-align: center; padding: 30px; color: var(--secondary-text); }

/* --- Paginacja --- */
.pagination {
    --bs-pagination-color: var(--accent-color);
    --bs-pagination-bg: var(--card-bg);
    --bs-pagination-border-color: var(--border-color);
    --bs-pagination-hover-color: var(--primary-bg);
    --bs-pagination-hover-bg: var(--accent-color);
    --bs-pagination-hover-border-color: var(--accent-color);
    --bs-pagination-focus-color: var(--primary-bg);
    --bs-pagination-focus-bg: var(--accent-color);
    --bs-pagination-active-color: var(--primary-bg);
    --bs-pagination-active-bg: var(--accent-color);
    --bs-pagination-active-border-color: var(--accent-color);
    --bs-pagination-disabled-color: var(--secondary-text);
    --bs-pagination-disabled-bg: var(--secondary-bg);
    --bs-pagination-disabled-border-color: var(--border-color);
}
body.light-mode .pagination { --bs-pagination-active-color: #fff; --bs-pagination-hover-color: #fff; --bs-pagination-focus-color: #fff; }

/* --- Stopka --- */
footer { 
    background-color: var(--secondary-bg); 
    padding: 4rem 0 2rem 0; 
    border-top: 1px solid var(--border-color);
    margin-top: auto; /* Kluczowe dla przyklejenia stopki */
}
footer .footer-heading { color: var(--accent-color); font-weight: 600; }
footer a { text-decoration: none; color: var(--secondary-text); }
footer a:hover { color: var(--accent-color) !important; }
footer .btn-social {
    width: 40px; height: 40px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
    border: 1px solid var(--border-color);
    transition: background-color .3s ease, color .3s ease;
}
footer .btn-social:hover { 
    background-color: var(--accent-color);
    color: var(--primary-bg) !important;
}
body.light-mode footer .btn-social:hover { color: #fff !important; }

/* --- Przycisk Powrotu na Górę --- */
.back-to-top {
    position: fixed;
    display: flex; /* Używamy flexbox do centrowania */
    align-items: center;
    justify-content: center;
    right: 30px;
    bottom: 30px;
    z-index: 99;
    background-color: var(--accent-color);
    color: var(--primary-bg);
    border: none;
    border-radius: 8px;
    width: 50px;
    height: 50px;
    font-size: 24px;
    transition: opacity 0.3s, visibility 0.3s, background-color 0.3s, transform 0.2s ease;
    opacity: 0;
    visibility: hidden;
}
body.light-mode .back-to-top { color: #fff; }
.back-to-top.show { opacity: 1; visibility: visible; }
.back-to-top:hover {
    background-color: var(--accent-color);
    color: var(--primary-bg);
    filter: brightness(0.9);
    transform: translateY(-3px);
}
body.light-mode .back-to-top:hover { color: #fff; }
</style>

</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.html">Fox24<span class="text-accent">Coin</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="homeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Home</a>
                    <ul class="dropdown-menu" aria-labelledby="homeDropdown">
                        <li><a class="dropdown-item" href="index.html">Home</a></li>
                        <li><a class="dropdown-item" href="widget.html">Widget</a></li>
                        <li><a class="dropdown-item" href="market.html">Crypto Market</a></li>
                        <li><a class="dropdown-item" href="https://fox24coin.com/scam-protection.html">Scam protection</a></li>
                        <li><a class="dropdown-item" href="vision.html">Fox24 Vision</a></li>
                   </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="tokenomics.html">Tokenomics</a></li>
                <li class="nav-item"><a class="nav-link" href="roadmap.html">Roadmap</a></li>
                <li class="nav-item"><a class="nav-link" href="team2.html">Team</a></li>
                <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="index.html#contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="https://fox24coin.com/uniswap.html">Price on Uniswap</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" href="https://github.com/rto-gtc/0xED9114c614aD6b948a1EA21f062F6e1D0b4e8308" target="_blank" aria-label="GitHub Repository" style="padding: 0.5rem;">
                         <i class="fab fa-github fa-lg"></i>
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center ms-lg-2">
                    <button id="theme-toggle" class="btn btn-sm btn-outline-accent" aria-label="Toggle theme">
                        <i class="fas fa-sun"></i>
                    </button>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-accent" href="whitepaper.pdf" target="_blank">Whitepaper</a>
                </li>
            </ul>
        </div>
    </div>
</nav>