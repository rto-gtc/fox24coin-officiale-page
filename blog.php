<?php
require 'includes/functions.php';

// --- USTAWIENIA PAGINACJI ---
$posts_per_page = 6; // Ile postów na jednej stronie

// --- POBIERANIE DANYCH Z URL ---
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

$filtered_category = $_GET['category'] ?? null;
$search_query = $_GET['search'] ?? null;

// --- POBIERANIE I FILTROWANIE POSTÓW ---
$all_posts = get_all_posts($search_query); // Przekazujemy zapytanie do funkcji
$all_categories = get_all_categories();

$posts_to_display = $all_posts;

// Filtrowanie po kategorii
if ($filtered_category) {
    $posts_to_display = array_filter($all_posts, function($post) use ($filtered_category) {
        return $post['category'] === $filtered_category;
    });
}

// --- LOGIKA PAGINACJI ---
$total_posts = count($posts_to_display);
$total_pages = ceil($total_posts / $posts_per_page);
$offset = ($current_page - 1) * $posts_per_page;
$posts_for_current_page = array_slice($posts_to_display, $offset, $posts_per_page);

// Ustawianie tytułu strony
if ($search_query) {
    $page_title = 'Wyniki wyszukiwania dla: ' . htmlspecialchars($search_query);
} elseif ($filtered_category) {
    $page_title = 'Artykuły z kategorii: ' . htmlspecialchars($filtered_category);
} else {
    $page_title = 'Fox24Coin Blog - News, Insights, and Updates';
}

include 'includes/header.php';
?>

<header class="page-hero">
    <div class="container text-center">
        <h1 class="display-3 fw-bold">Our <span class="text-gold">Blog</span></h1>
        <p class="lead">Latest news, insights, and updates from the Fox24Coin world.</p>
    </div>
</header>

<section class="section" id="Latest">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <form action="blog.php" method="get">
                    <div class="input-group input-group-lg">
                        <input type="search" name="search" class="form-control" placeholder="Search articles..." value="<?= htmlspecialchars($search_query ?? '') ?>">
                        <button class="btn btn-gold" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mb-5">
            <h2 class="mb-3"><i class="fas fa-newspaper me-3 text-gold"></i>
                <?php
                    if ($search_query) {
                        echo 'Search Results <span class="text-white-50 fs-5">(' . $total_posts . ' found)</span>';
                    } elseif ($filtered_category) {
                        echo 'Category: <span class="text-gold">' . htmlspecialchars($filtered_category) . '</span>';
                    } else {
                        echo 'Latest <span class="text-gold">Articles</span>';
                    }
                ?>
            </h2>
            <?php if ($search_query || $filtered_category): ?>
                <a href="blog.php" class="btn-read-more">Clear filters and show all</a>
            <?php endif; ?>
        </div>

        <div class="row g-4">
            <?php if (empty($posts_for_current_page)): ?>
                <div class="col">
                    <p class="text-center lead">No articles found matching your criteria.</p>
                </div>
            <?php else: ?>
                <?php foreach ($posts_for_current_page as $post): ?>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <article class="post-card w-100">
                            <a href="post.php?slug=<?= $post['slug'] ?>">
                               <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" style="height: 200px; width: 100%; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="post.php?slug=<?= $post['slug'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                                </h5>
                                <p class="card-text flex-grow-1">
                                    <?php
                                        $excerpt = strip_tags($post['content_html']);
                                        echo substr($excerpt, 0, 120) . '...';
                                    ?>
                                </p>
                                <div class="mt-auto">
                                    <p class="post-meta">
                                        <i class="fas fa-calendar-alt me-2"></i>Published on <time datetime="<?= $post['date'] ?>"><?= date('F j, Y', strtotime($post['date'])) ?></time>
                                    </p>
                                    <a href="post.php?slug=<?= $post['slug'] ?>" class="btn-read-more">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php
                        // Przygotowujemy parametry URL, aby paginacja działała z filtrami
                        $queryParams = [];
                        if ($filtered_category) $queryParams['category'] = $filtered_category;
                        if ($search_query) $queryParams['search'] = $search_query;

                        // Strzałka "Wstecz"
                        if ($current_page > 1) {
                            $queryParams['page'] = $current_page - 1;
                            echo '<li class="page-item"><a class="page-link" href="?'.http_build_query($queryParams).'">Previous</a></li>';
                        }

                        // Linki do stron
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $queryParams['page'] = $i;
                            $activeClass = ($i == $current_page) ? 'active' : '';
                            echo '<li class="page-item '.$activeClass.'"><a class="page-link" href="?'.http_build_query($queryParams).'">'.$i.'</a></li>';
                        }
                        
                        // Strzałka "Dalej"
                        if ($current_page < $total_pages) {
                            $queryParams['page'] = $current_page + 1;
                            echo '<li class="page-item"><a class="page-link" href="?'.http_build_query($queryParams).'">Next</a></li>';
                        }
                    ?>
                </ul>
            </nav>
        <?php endif; ?>

    </div>
</section>

<section class="section bg-dark-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="mb-3">Stay Ahead of the Curve</h2>
                <p class="lead mb-4">Subscribe to our newsletter for exclusive updates, market analysis, and early access to our features.</p>
                <form>
                    <div class="input-group input-group-lg">
                        <input type="email" class="form-control" placeholder="Enter your email address" aria-label="Enter your email address">
                        <button class="btn btn-gold" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="mb-3">Explore by <span class="text-gold">Category</span></h2>
            <p>Find articles that interest you the most.</p>
        </div>
        <div class="d-flex justify-content-center flex-wrap gap-2">
            <?php foreach ($all_categories as $cat_name => $count): ?>
                 <a href="blog.php?category=<?= urlencode($cat_name) ?>" class="btn btn-outline-gold"><?= htmlspecialchars($cat_name) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section bg-dark-2 author-spotlight">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-4 text-center">
                <img src="https://static.wixstatic.com/media/e0bdea_888763a5f5ed46bfa08f7186690bb5e4~mv2.png" class="img-fluid rounded-circle" alt="Michał Rzepczyński" style="width: 200px; height: 200px; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <blockquote class="mb-4">
                    "Our vision with Fox24Coin is not just to create another digital currency, but to build a lasting bridge between the timeless value of gold and the limitless potential of blockchain technology."
                </blockquote>
                <p class="mb-0"><strong>Michał Rzepczyński</strong></p>
                <p class="text-gold">Founder & CEO of Fox24Coin</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
