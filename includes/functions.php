<?php
/**
 * Główny plik z funkcjami bloga - wersja ostateczna i bezpieczna.
 * Poprawiona funkcja CoinGecko, aby nie zawieszała strony.
 * Poprawione ścieżki do plików, aby działały z każdego miejsca.
 */

// Wczytujemy bibliotekę Parsedown (jeśli istnieje)
if (file_exists(__DIR__ . '/../parsedown.php')) {
    require_once __DIR__ . '/../parsedown.php';
} elseif (file_exists(__DIR__ . '/parsedown.php')) {
    require_once __DIR__ . '/parsedown.php';
}

// --- FUNKCJA DO OBSŁUGI COINGECKO (NAPRAWIONA WERSJA Z cURL) ---
/**
 * Pobiera dane z CoinGecko przy użyciu cURL z limitem czasu.
 * Zapobiega zawieszaniu się strony, gdy API nie odpowiada.
 *
 * @return string Kod HTML tabeli z danymi lub komunikat o błędzie.
 */
function get_coingecko_table_html() {
    $cache_file = __DIR__ . '/coingecko_cache.json';
    $cache_time = 300; // Cache na 5 minut

    // Sprawdź, czy istnieje ważny plik cache
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_time) {
        $data = json_decode(file_get_contents($cache_file), true);
    } else {
        $api_url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=10&page=1&sparkline=false';

        // Inicjalizacja cURL - bezpieczny sposób na zapytania API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); // Limit czasu na połączenie (2 sekundy)
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);       // Całkowity limit czasu na wykonanie zapytania (5 sekund)
        $json_data = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Sprawdź, czy zapytanie się powiodło
        if ($json_data === false || $http_code != 200) {
            // Zwróć błąd, ale nie zawieszaj strony
            return '<p class="text-danger text-center">Błąd: Tabela kursów jest tymczasowo niedostępna.</p>';
        }
        
        $data = json_decode($json_data, true);
        
        // Zapisz do cache tylko jeśli dane są poprawne
        if (is_array($data) && !empty($data)) {
            file_put_contents($cache_file, json_encode($data));
        }
    }

    if (!is_array($data) || empty($data)) {
        return '<p class="text-center">Brak danych do wyświetlenia.</p>';
    }

    // Budowanie tabeli HTML (bez zmian)
    $html = '<table class="crypto-table">';
    $html .= '<thead><tr><th>#</th><th>Moneta</th><th>Cena</th><th>Zmiana 24h</th><th>Kapitalizacja</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($data as $coin) {
        $change24h = $coin['price_change_percentage_24h'] ?? 0;
        $priceChangeClass = ($change24h >= 0) ? 'price-up' : 'price-down';
        
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($coin['market_cap_rank'] ?? 'N/A') . '</td>';
        $html .= '<td><div class="coin-info"><img src="' . htmlspecialchars($coin['image'] ?? '') . '" alt="' . htmlspecialchars($coin['name'] ?? '') . '" class="coin-icon"><strong>' . htmlspecialchars($coin['name'] ?? 'B/D') . '</strong> (' . strtoupper(htmlspecialchars($coin['symbol'] ?? '---')) . ')</div></td>';
        $html .= '<td>$' . number_format($coin['current_price'] ?? 0, 2) . '</td>';
        $html .= '<td class="' . $priceChangeClass . '">' . number_format($change24h, 2) . '%</td>';
        $html .= '<td>$' . number_format($coin['market_cap'] ?? 0) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

// --- FUNKCJE DO OBSŁUGI BLOGA (Z POPRAWIONYMI ŚCIEŻKAMI) ---

function _fetch_all_posts() {
    static $cached_posts = null;
    if ($cached_posts !== null) return $cached_posts;

    $posts = [];
    $postsDir = __DIR__ . '/../posts'; // Poprawna, uniwersalna ścieżka do folderu z postami
    
    $files = glob($postsDir . '/*.md');
    if ($files === false) return [];
    
    foreach ($files as $file) {
        if ($post = parse_post_file($file)) {
            $posts[] = $post;
        }
    }
    
    // Sortowanie postów od najnowszego do najstarszego
    usort($posts, function ($a, $b) {
        return strtotime($b['date'] ?? 0) - strtotime($a['date'] ?? 0);
    });
    
    $cached_posts = $posts;
    return $cached_posts;
}

function parse_post_file($filepath) {
    if (!file_exists($filepath) || !is_readable($filepath)) return null;
    
    $content = file_get_contents($filepath);
    if ($content === false) return null;
    
    preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)/s', $content, $matches);
    if (count($matches) !== 3) return null;

    $metadata = [];
    $lines = explode("\n", trim($matches[1]));
    foreach ($lines as $line) {
        if (strpos($line, ':') !== false) {
            list($key, $value) = explode(':', $line, 2);
            $metadata[trim($key)] = trim($value);
        }
    }

    if (class_exists('Parsedown')) {
        $parsedown = new Parsedown();
        $metadata['content_html'] = $parsedown->text($matches[2]);
    } else {
        $metadata['content_html'] = '<p>' . htmlspecialchars($matches[2]) . '</p>'; // Fallback
    }

    $metadata['slug'] = pathinfo($filepath, PATHINFO_FILENAME);
    return $metadata;
}

function get_all_posts($searchQuery = null) {
    $all_posts = _fetch_all_posts();
    if (empty(trim((string)$searchQuery))) return $all_posts;

    return array_filter($all_posts, function($post) use ($searchQuery) {
        $titleMatch = isset($post['title']) && stripos($post['title'], $searchQuery) !== false;
        $contentMatch = isset($post['content_html']) && stripos(strip_tags($post['content_html']), $searchQuery) !== false;
        return $titleMatch || $contentMatch;
    });
}

function get_post_by_slug($slug) {
    $safe_slug = preg_replace('/[^a-zA-Z0-9_-]/', '', $slug);
    $filepath = __DIR__ . "/../posts/" . $safe_slug . ".md";
    return parse_post_file($filepath);
}

function get_all_categories() {
    $posts = _fetch_all_posts();
    $categories = [];
    foreach ($posts as $post) {
        if (!empty($post['category'])) {
            $cat_name = trim($post['category']);
            $categories[$cat_name] = ($categories[$cat_name] ?? 0) + 1;
        }
    }
    arsort($categories);
    return $categories;
}
?>