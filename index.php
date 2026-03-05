<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$default_lang = 'pt';

// garante que lang sempre seja 'pt' ou 'en'
$lang = $_SESSION['lang'] ?? $default_lang;
$lang = is_string($lang) ? strtolower(trim($lang)) : $default_lang;
if (!in_array($lang, ['pt','en'], true)) {
  $lang = $default_lang;
  $_SESSION['lang'] = $lang;
}

// agora sim calcula o booleano
$isPT = ($lang === 'pt');

// (opcional) carrega arquivo de idioma
$langFile = __DIR__ . "/lang/$lang.php";
if (file_exists($langFile)) {
  require_once $langFile;
}

// debug
echo "<!-- lang={$lang} isPT=" . ($isPT ? 'true' : 'false') . " sid=" . session_id() . " -->";


// --- CONFIG ---
$wpBase = 'https://www.isacaguiar.com.br/blog'; // use o mesmo do navegador (no print aparece com www)

// --- CACHE ---
function cache_read($file, $ttlSeconds) {
  if (!file_exists($file)) return null;
  if ((time() - filemtime($file)) > $ttlSeconds) return null;
  $raw = @file_get_contents($file);
  if ($raw === false) return null;
  $data = json_decode($raw, true);
  return is_array($data) ? $data : null;
}

function cache_write($file, $data) {
  @file_put_contents($file, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}

// --- HTTP JSON (cURL -> fallback) ---
function http_get_json($url, $timeoutSeconds = 6) {
  if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_MAXREDIRS => 5,
      CURLOPT_CONNECTTIMEOUT => $timeoutSeconds,
      CURLOPT_TIMEOUT => $timeoutSeconds,
      CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'User-Agent: isacaguiar-site'
      ],
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $raw = curl_exec($ch);
    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false || $httpCode < 200 || $httpCode >= 300) return null;

    $data = json_decode($raw, true);
    return is_array($data) ? $data : null;
  }

  $ctx = stream_context_create([
    'http' => [
      'method' => 'GET',
      'timeout' => $timeoutSeconds,
      'header' => "Accept: application/json\r\nUser-Agent: isacaguiar-site\r\n"
    ]
  ]);

  $raw = @file_get_contents($url, false, $ctx);
  if ($raw === false) return null;

  $data = json_decode($raw, true);
  return is_array($data) ? $data : null;
}

// --- WP: pega ID da categoria pelo SLUG (correto) ---
function wp_get_category_id_by_slug($wpBase, $slug) {
  $slug = trim($slug);
  if ($slug === '') return null;

  $cacheFile = __DIR__ . "/assets/json/wp-cat-{$slug}.json";
  $cached = cache_read($cacheFile, 24 * 60 * 60);
  if (is_array($cached) && isset($cached['id'])) return (int)$cached['id'];

  // ✅ CORRETO: slug=
  $url = $wpBase . '/wp-json/wp/v2/categories?per_page=1&slug=' . urlencode($slug);
  $data = http_get_json($url, 6);

  if (!is_array($data) || empty($data) || !isset($data[0]['id'])) return null;

  $id = (int)$data[0]['id'];
  cache_write($cacheFile, ['id' => $id, 'slug' => $slug]);
  return $id;
}

// --- WP: pega IDs dos filhos de um pai (subcategorias) ---
function wp_get_child_category_ids($wpBase, $parentId) {
  $parentId = (int)$parentId;
  if ($parentId <= 0) return [];

  $cacheFile = __DIR__ . "/assets/json/wp-cat-children-{$parentId}.json";
  $cached = cache_read($cacheFile, 24 * 60 * 60);
  if (is_array($cached)) return $cached;

  // Busca até 100 subcategorias
  $url = $wpBase . "/wp-json/wp/v2/categories?per_page=100&parent={$parentId}";
  $data = http_get_json($url, 6);
  if (!is_array($data)) return [];

  $ids = [];
  foreach ($data as $c) {
    if (isset($c['id'])) $ids[] = (int)$c['id'];
  }

  cache_write($cacheFile, $ids);
  return $ids;
}

// --- WP: busca posts por VÁRIAS categorias (pai + filhos) ---
function wp_fetch_posts_by_categories($wpBase, array $categoryIds, $count = 3) {
  $count = max(1, min(8, (int)$count));
  $categoryIds = array_values(array_unique(array_filter(array_map('intval', $categoryIds))));
  if (empty($categoryIds)) return [];

  // cache por hash das categorias
  $hash = md5(implode(',', $categoryIds) . '|' . $count);
  $cacheFile = __DIR__ . "/assets/json/wp-posts-{$hash}.json";

  $cached = cache_read($cacheFile, 15 * 60);
  if (is_array($cached)) return $cached;

  // ✅ WP aceita categories=1,2,3 (OR / category__in)
  $cats = implode(',', $categoryIds);
  $url = $wpBase . "/wp-json/wp/v2/posts?per_page={$count}&categories={$cats}&_embed=1";
  $data = http_get_json($url, 6);

  if (!is_array($data)) {
    // fallback: tenta cache antigo mesmo expirado
    if (file_exists($cacheFile)) {
      $raw = @file_get_contents($cacheFile);
      $old = $raw ? json_decode($raw, true) : null;
      if (is_array($old)) return $old;
    }
    return [];
  }

  $posts = [];
  foreach ($data as $p) {
    $title = isset($p['title']['rendered']) ? strip_tags($p['title']['rendered']) : 'Post';
    $link  = isset($p['link']) ? $p['link'] : ($wpBase . '/');
    $date  = isset($p['date']) ? substr($p['date'], 0, 10) : '';
    $excerpt = isset($p['excerpt']['rendered']) ? trim(strip_tags($p['excerpt']['rendered'])) : '';
    $excerpt = preg_replace('/\s+/', ' ', $excerpt);
    if (mb_strlen($excerpt) > 160) $excerpt = mb_substr($excerpt, 0, 157) . '...';

    $img = '';
    if (isset($p['_embedded']['wp:featuredmedia'][0]['source_url'])) {
      $img = $p['_embedded']['wp:featuredmedia'][0]['source_url'];
    }

    $posts[] = [
      'title' => $title,
      'link' => $link,
      'date' => $date,
      'excerpt' => $excerpt,
      'img' => $img
    ];
  }

  cache_write($cacheFile, $posts);
  return $posts;
}

// --- AJUSTE SLUGS AQUI ---
$techCategorySlug  = 'tecnologia';
$sportCategorySlug = 'esportes';

// --- TECNOLOGIA: pega pai + filhos e busca posts ---
$techParentId = wp_get_category_id_by_slug($wpBase, $techCategorySlug);
$techChildIds = $techParentId ? wp_get_child_category_ids($wpBase, $techParentId) : [];
$techCategoryIds = $techParentId ? array_merge([$techParentId], $techChildIds) : [];
$techPosts = wp_fetch_posts_by_categories($wpBase, $techCategoryIds, 3);

// --- ESPORTES: idem ---
$sportParentId = wp_get_category_id_by_slug($wpBase, $sportCategorySlug);
$sportChildIds = $sportParentId ? wp_get_child_category_ids($wpBase, $sportParentId) : [];
$sportCategoryIds = $sportParentId ? array_merge([$sportParentId], $sportChildIds) : [];
$sportPosts = wp_fetch_posts_by_categories($wpBase, $sportCategoryIds, 3);


/**
 * Textos básicos PT/EN (para não depender do arquivo lang)
 */

echo "<!-- isPT=" . ($isPT ? 'true' : 'false') . " -->";

$txt = [
  'brand' => 'Isac Aguiar',
  'tagline' => $isPT ? 'Backend Engineer • Java • Arquitetura • Sistemas Distribuídos' : 'Backend Engineer • Java • Architecture • Distributed Systems',
  'hero_title' => $isPT ? 'Arquitetura backend, resiliência e performance em escala.' : 'Backend architecture, resilience and performance at scale.',
  'hero_desc' => $isPT
    ? 'Conteúdos e projetos sobre Java/Spring, sistemas distribuídos, mensageria e performance — com um espaço pessoal para esportes.'
    : 'Content and projects about Java/Spring, distributed systems, messaging and performance — plus a personal space for sports.',
  'btn_blog' => $isPT ? 'Ver blog' : 'Read blog',
  'btn_cv' => $isPT ? 'Currículo' : 'Resume',
  'btn_projects' => $isPT ? 'Projetos' : 'Projects',
  'section_tech' => $isPT ? 'Últimos artigos de Tecnologia' : 'Latest Tech articles',
  'section_sports' => $isPT ? 'Últimos artigos de Esportes' : 'Latest Sports articles',
  'view_all' => $isPT ? 'Ver tudo' : 'View all',
  'fallback' => $isPT ? 'Acesse o blog para ver os posts.' : 'Go to the blog to see posts.',
  'cta_title' => $isPT ? 'Quer trocar uma ideia?' : 'Want to talk?',
  'cta_desc' => $isPT ? 'Me chama no LinkedIn ou no WhatsApp.' : 'Reach me on LinkedIn or WhatsApp.',
  'nav_home' => $isPT ? 'Home' : 'Home',
  'nav_blog' => $isPT ? 'Blog' : 'Blog',
  'nav_projects' => $isPT ? 'Projetos' : 'Projects',
  'nav_about' => $isPT ? 'Sobre' : 'About',
  'nav_contact' => $isPT ? 'Contato' : 'Contact',
  'nav_language' => $isPT ? 'Idioma' : 'Language',
];

?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo htmlspecialchars($txt['brand'] . ' — ' . ($isPT ? 'Java Backend e Arquitetura' : 'Java Backend & Architecture')); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($txt['hero_desc']); ?>">
  <link rel="canonical" href="https://www.isacaguiar.com.br/">

  <meta property="og:type" content="website">
  <meta property="og:title" content="<?php echo htmlspecialchars($txt['brand']); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($txt['hero_desc']); ?>">
  <meta property="og:url" content="https://www.isacaguiar.com.br/">
  <meta property="og:image" content="https://www.isacaguiar.com.br/assets/img/profile.jpg">

  <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="assets/css/home.css" rel="stylesheet" />

  <script>
    (function () {
      const saved = localStorage.getItem('theme'); // 'light' | 'dark' | null
      const systemDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
      const theme = saved ? saved : (systemDark ? 'dark' : 'light');
      document.documentElement.setAttribute('data-theme', theme);
    })();
  </script>

  <!-- GA (mantenha o seu se quiser) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-XCB9J0HPCH"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-GSMMHGW5QX');
  </script>
</head>

<body>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2 text-white fw-bold" href="/">
      <!--span class="brand-badge" aria-hidden="true"></span-->
      <span class="muted"><?php echo htmlspecialchars($txt['brand']); ?></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="/"><?php echo htmlspecialchars($txt['nav_home']); ?></a></li>
        <li class="nav-item"><a class="nav-link" target="_blank" href="/blog/"><?php echo htmlspecialchars($txt['nav_blog']); ?></a></li>
        <!--li class="nav-item"><a class="nav-link" href="projects.php"><?php echo htmlspecialchars($txt['nav_projects']); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="about.php"><?php echo htmlspecialchars($txt['nav_about']); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php"><?php echo htmlspecialchars($txt['nav_contact']); ?></a></li-->

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <?php echo htmlspecialchars($txt['nav_language']); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="/switch_language.php?lang=pt">Português</a></li>
            <li><a class="dropdown-item" href="/switch_language.php?lang=en">English</a></li>
          </ul>
        </li>

        <!--li class="nav-item ms-lg-2">
          <a class="btn btn-primary btn-sm" href="cv.php"><?php echo htmlspecialchars($txt['btn_cv']); ?></a>
        </li-->

        <li class="nav-item ms-lg-2">
          <button class="theme-toggle" type="button" id="themeToggle" aria-label="Alternar tema">
            <span id="themeIcon">🌙</span>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<header class="hero">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <div class="chip mb-3"><?php echo htmlspecialchars($txt['tagline']); ?></div>
        <h1 class="display-5 mb-3"><?php echo htmlspecialchars($txt['hero_title']); ?></h1>
        <p class="lead mb-4"><?php echo htmlspecialchars($txt['hero_desc']); ?></p>

        <div class="d-flex gap-2 flex-wrap">
          <a class="btn btn-primary" target="_blank" href="http://isacaguiar.com/blog/"><?php echo htmlspecialchars($txt['btn_blog']); ?></a>
          <!--a class="btn btn-outline-theme" href="projects.php"><?php echo htmlspecialchars($txt['btn_projects']); ?></a>
          <a class="btn btn-outline-theme" href="cv.php"><?php echo htmlspecialchars($txt['btn_cv']); ?></a-->
        </div>

      </div>

      <div class="col-lg-5">
        <div class="card">
          <div class="p-4 d-flex align-items-center gap-3">
            <img src="assets/img/profile.jpg" alt="Isac Aguiar" width="76" height="76" class="rounded-circle" style="object-fit:cover;border:1px solid rgba(255,255,255,.12)">
            <div>
              <div class="fw-bold">Isac Aguiar</div>
              <div class="muted"><?php echo $isPT ? 'Java • Arquitetura • Performance' : 'Java • Architecture • Performance'; ?></div>
              <div class="mt-2 d-flex gap-2 flex-wrap">
                <a class="btn btn-sm btn-outline-theme" target="_blank" rel="noopener" href="https://www.linkedin.com/in/isac-aguiar-0889178/">LinkedIn</a>
                <a class="btn btn-sm btn-outline-theme" target="_blank" rel="noopener" href="https://github.com/isacaguiar">GitHub</a>
                <a class="btn btn-sm btn-outline-theme" target="_blank" rel="noopener"
                   href="https://api.whatsapp.com/send?phone=5571992227254&text=Ol%C3%A1%2C%20vi%20seu%20site%20e%20quero%20falar%20com%20voc%C3%AA.">
                  WhatsApp
                </a>
              </div>
            </div>
          </div>
          <div class="px-4 pb-4 small" style="color:rgba(229,231,235,.65)">

            <hr class="muted" />

            <ul class="list-unstyled mb-0 small muted">
              <li class="mb-2">✅
                  <?php echo $isPT
                        ? 'Java / Spring Boot / APIs'
                        : 'Java / Spring Boot / APIs'; ?>
              </li>
              <li class="mb-2">✅
                  <?php echo $isPT
                        ? 'Resiliência (retry, circuit breaker, fallback)'
                        : 'Resiliece (retry, circuit breaker, fallback)'; ?>
              </li>
              <li class="mb-2">✅
                  <?php echo $isPT
                        ? 'Performance / SQL / Observabilidade'
                        : 'Performance / SQL / Observability'; ?>
              </li>
              <li>✅
                  <?php echo $isPT
                          ? 'Mensageria & integrações'
                          : 'Messaging & integrations'; ?>
              </li>
            </ul>

            <?php /* echo $isPT
              ? 'Home focada em tech. O blog tem tech + esportes em categorias separadas.'
              : 'Tech-focused homepage. Blog includes tech + sports in separate categories.'; */ ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<main class="pb-5">
  <!-- TECNOLOGIA -->
  <section class="py-4">
    <div class="container">
      <div class="section-title mb-3">
        <div>
          <h2 class="h3 mb-1"><?php echo htmlspecialchars($txt['section_tech']); ?></h2>
          <p><?php echo $isPT ? 'Conteúdo para autoridade e tráfego orgânico.' : 'Content for authority and organic traffic.'; ?></p>
        </div>
        <a class="btn btn-sm btn-outline-theme" target="_blank" href="/blog/category/<?php echo htmlspecialchars($techCategorySlug); ?>/">
          <?php echo htmlspecialchars($txt['view_all']); ?>
        </a>
      </div>

      <div class="row g-3">
        <?php if (empty($techPosts)): ?>
          <div class="col-12">
            <div class="alert alert-dark border" style="border-color:rgba(255,255,255,.10)!important;background:rgba(255,255,255,.03)">
              <?php echo htmlspecialchars($txt['fallback']); ?>
            </div>
          </div>
        <?php else: ?>
          <?php foreach ($techPosts as $p): ?>
            <div class="col-md-6 col-lg-4">
              <a class="text-decoration-none" href="<?php echo htmlspecialchars($p['link']); ?>">
                <div class="card h-100">
                  <div class="thumb">
                    <?php if (!empty($p['img'])): ?>
                      <img src="<?php echo htmlspecialchars($p['img']); ?>" alt="">
                    <?php endif; ?>
                    <span class="thumb-label"><?php echo $p['date'] ? htmlspecialchars($p['date']) : 'Tech'; ?></span>
                  </div>
                  <div class="p-3">
                    <div class="fw-bold mb-1"><?php echo htmlspecialchars($p['title']); ?></div>
                    <div class="muted"><?php echo htmlspecialchars($p['excerpt']); ?></div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ESPORTES -->
  <section class="py-4">
    <div class="container">
      <div class="section-title mb-3">
        <div>
          <h2 class="h3 mb-1"><?php echo htmlspecialchars($txt['section_sports']); ?></h2>
          <p><?php echo $isPT ? 'Espaço pessoal: jiu-jitsu, boxe, surf, capoeira.' : 'Personal space: jiu-jitsu, boxing, surf, capoeira.'; ?></p>
        </div>
        <a class="btn btn-sm btn-outline-theme" target="_blank" href="/blog/category/<?php echo htmlspecialchars($sportCategorySlug); ?>/">
          <?php echo htmlspecialchars($txt['view_all']); ?>
        </a>
      </div>

      <div class="row g-3">
        <?php if (empty($sportPosts)): ?>
          <div class="col-12">
            <div class="alert alert-dark border" style="border-color:rgba(255,255,255,.10)!important;background:rgba(255,255,255,.03)">
              <?php echo $isPT
                ? 'Ainda sem posts em Esportes. Publique no WP na categoria “Esportes” e eles aparecerão aqui.'
                : 'No Sports posts yet. Publish in the “Sports” category on WP and they’ll show up here.'; ?>
            </div>
          </div>
        <?php else: ?>
          <?php foreach ($sportPosts as $p): ?>
            <div class="col-md-6 col-lg-4">
              <a class="text-decoration-none" href="<?php echo htmlspecialchars($p['link']); ?>">
                <div class="card h-100">
                  <div class="thumb">
                    <?php if (!empty($p['img'])): ?>
                      <img src="<?php echo htmlspecialchars($p['img']); ?>" alt="">
                    <?php endif; ?>
                    <span class="thumb-label"><?php echo $p['date'] ? htmlspecialchars($p['date']) : 'Sports'; ?></span>
                  </div>
                  <div class="p-3">
                    <div class="fw-bold mb-1"><?php echo htmlspecialchars($p['title']); ?></div>
                    <div class="muted"><?php echo htmlspecialchars($p['excerpt']); ?></div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-4">
    <div class="container">
      <div class="cta">
        <div class="row align-items-center g-3">
          <div class="col-lg-8">
            <h3 class="h4 mb-1"><?php echo htmlspecialchars($txt['cta_title']); ?></h3>
            <div class="muted"><?php echo htmlspecialchars($txt['cta_desc']); ?></div>
          </div>
          <div class="col-lg-4 text-lg-end">
            <a class="btn btn-primary" target="_blank" rel="noopener" href="https://www.linkedin.com/in/isac-aguiar-0889178/">LinkedIn</a>
            <a class="btn btn-outline-theme ms-2" target="_blank" rel="noopener"
               href="https://api.whatsapp.com/send?phone=5571992227254&text=Ol%C3%A1%2C%20vi%20seu%20site%20e%20quero%20falar%20com%20voc%C3%AA.">
              WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="footer py-4">
  <div class="container d-flex flex-wrap gap-2 justify-content-between align-items-center">
    <div class="small">© <?php echo date('Y'); ?> Isac Aguiar</div>
    <div class="small">
      <a class="text-decoration-none text-white-50 me-3 muted" href="/blog/">Blog</a>
      <a class="text-decoration-none text-white-50 me-3 muted" href="cv.php"><?php echo htmlspecialchars($txt['btn_cv']); ?></a>
      <a class="text-decoration-none text-white-50 muted" target="_blank" rel="noopener" href="https://github.com/isacaguiar">GitHub</a>
    </div>
  </div>
</footer>
<script data-ad-client="ca-pub-4296112592408779" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.textContent = theme === 'dark' ? '🌙' : '☀️';
  }

  const current = document.documentElement.getAttribute('data-theme') || 'dark';
  applyTheme(current);

  document.getElementById('themeToggle')?.addEventListener('click', () => {
    const t = document.documentElement.getAttribute('data-theme') || 'dark';
    applyTheme(t === 'dark' ? 'light' : 'dark');
  });
</script>
</body>
</html>