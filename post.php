<?php
require 'includes/functions.php';

// Pobierz "slug" z URL, np. post.php?slug=why-gold-backed-crypto-is-the-future
$slug = $_GET['slug'] ?? null;

// Jeśli brak sluga, przekieruj na stronę główną bloga
if (!$slug) {
    header("Location: blog.php");
    exit;
}

// Pobierz dane posta na podstawie sluga
$post = get_post_by_slug($slug);

// Jeśli post nie istnieje, wyświetl stronę 404
if (!$post) {
    http_response_code(404);
    $page_title = '404 - Nie znaleziono posta';
    include 'includes/header.php';
    echo '<div class="container text-center section"><h1 class="text-gold">404</h1><p>Przepraszamy, ale artykuł, którego szukasz, nie istnieje.</p><a href="blog.php" class="btn btn-outline-gold">Wróć na bloga</a></div>';
    include 'includes/footer.php';
    exit;
}

// --- POPRAWKA SEO: Lepsze generowanie opisu strony ---
// Ustaw dynamicznie tytuł i opis dla SEO
$page_title = ($post['title'] ?? 'Post') . ' - Fox24Coin Blog';

if (!empty($post['description'])) {
    $page_description = $post['description'];
} else {
    // Tworzymy opis z treści posta, ucinając tekst do ostatniego pełnego słowa
    $raw_content = strip_tags($post['content_html']);
    $limit = 155;
    if (mb_strlen($raw_content) > $limit) {
        $substring = mb_substr($raw_content, 0, $limit);
        $last_space_pos = mb_strrpos($substring, ' ');
        if ($last_space_pos !== false) {
            $page_description = mb_substr($substring, 0, $last_space_pos) . '...';
        } else {
            $page_description = $substring . '...';
        }
    } else {
        $page_description = $raw_content;
    }
}

include 'includes/header.php';

// --- POPRAWKA LOGIKI: Lepsze pobieranie ostatnich postów ---
// Pobierz wszystkie kategorie
$all_categories = get_all_categories();

// Pobierz 4 najnowsze posty, aby po odfiltrowaniu bieżącego zostały 3
$all_posts = get_all_posts();
$recent_posts_pool = array_slice($all_posts, 0, 4); 
$recent_posts = [];
foreach ($recent_posts_pool as $recent_post) {
    // Dodaj post do listy tylko, jeśli to nie jest aktualnie wyświetlany post
    if ($recent_post['slug'] !== $slug) {
        $recent_posts[] = $recent_post;
    }
}
// Upewnij się, że na liście są maksymalnie 3 posty
$recent_posts = array_slice($recent_posts, 0, 3);
?>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 main-content-col">
                <article>
                    <header class="post-header mb-4">
                        <h1 class="post-title"><?= htmlspecialchars($post['title'] ?? 'Brak Tytułu') ?></h1>
                        <div class="post-meta">
                            <span>By <a href="#"><?= htmlspecialchars($post['author'] ?? 'Anonim') ?></a></span> |
                            <span>Published on <time datetime="<?= $post['date'] ?? '' ?>"><?= isset($post['date']) ? date('F j, Y', strtotime($post['date'])) : '' ?></time></span> |
                            <span>Category: <a href="blog.php?category=<?= urlencode($post['category'] ?? '') ?>"><?= htmlspecialchars($post['category'] ?? 'Brak') ?></a></span>
                        </div>
                    </header>
                    
                    <?php if (!empty($post['image'])): ?>
                        <img src="<?= htmlspecialchars($post['image']) ?>" class="img-fluid rounded mb-4" alt="<?= htmlspecialchars($post['title'] ?? '') ?>">
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <?php
                            // Zastępujemy shortcode [coingecko_table] na właściwą tabelę
                            $content = str_replace('[coingecko_table]', get_coingecko_table_html(), $post['content_html']);
                            echo $content;
                        ?>
                    </div>

                    <hr class="my-5" style="border-color: var(--border-color);">

                    <div class="post-tags">
                        <h5 class="mb-3">Tags:</h5>
                        <?php if(!empty($post['tags']) && is_array($post['tags'])): ?>
                            <?php foreach ($post['tags'] as $tag): ?>
                                <a href="blog.php?search=<?= urlencode($tag) ?>" class="tag-badge"><?= htmlspecialchars($tag) ?></a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="share-buttons mt-4">
                        <h5>Share this article:</h5>
                        <?php
                            // Dynamiczne pobieranie pełnego adresu URL i tytułu posta
                            $postUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            $postTitle = urlencode($post['title'] ?? 'Check out this article');
                            $postImage = !empty($post['image']) ? urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . htmlspecialchars($post['image'])) : '';
                        ?>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($postUrl) ?>&text=<?= $postTitle ?>" target="_blank" rel="noopener noreferrer" class="share-button twitter"><i class="fab fa-twitter"></i> Twitter</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($postUrl) ?>" target="_blank" rel="noopener noreferrer" class="share-button facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($postUrl) ?>&title=<?= $postTitle ?>" target="_blank" rel="noopener noreferrer" class="share-button linkedin"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                        <a href="https://www.pinterest.com/pin/create/button/?url=<?= urlencode($postUrl) ?>&media=<?= $postImage ?>&description=<?= $postTitle ?>" target="_blank" rel="noopener noreferrer" class="share-button pinterest"><i class="fab fa-pinterest"></i> Pinterest</a>
                        <a href="https://medium.com/new-story" target="_blank" rel="noopener noreferrer" class="share-button medium" title="Share on Medium (requires copy-paste)"><i class="fab fa-medium"></i> Medium</a>
                        <a href="mailto:?subject=<?= $postTitle ?>&body=Check out this article: <?= urlencode($postUrl) ?>" class="share-button email"><i class="fas fa-envelope"></i> Email</a>
                    </div>
                </article>
            </div> <aside class="col-lg-4 sidebar-col mt-5 mt-lg-0">
                <div class="sidebar-widget">
                    <h4 class="widget-title">Categories</h4>
                    <ul>
                        <?php foreach ($all_categories as $cat_name => $count): ?>
                            <li>
                                <a href="blog.php?category=<?= urlencode($cat_name) ?>">
                                    <?= htmlspecialchars($cat_name) ?> (<?= $count ?>)
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h4 class="widget-title">Recent Posts</h4>
                    <ul>
                        <?php foreach($recent_posts as $recent_post): ?>
                            <li>
                                <a href="post.php?slug=<?= $recent_post['slug'] ?>">
                                    <?= htmlspecialchars($recent_post['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h4 class="widget-title">Swap Tokens</h4>
                    <div style="margin-top: 1rem;">
                        <iframe src="https://dexappbuilder.dexkit.com/_widget_iframe?widgetId=74" frameborder="0" width="100%" height="500px" style="border-radius: 8px;"></iframe>
                    </div>
                </div>

                <div class="sidebar-widget text-center mt-4">
                    <a href="https://fox24coin.com/youtube.html" target="_blank" class="btn btn-danger w-100 fw-bold">
                        🎥 YouTube No Ads
                    </a>
                </div>
            </aside> </div> </div> </section> <?php include 'includes/footer.php'; ?>