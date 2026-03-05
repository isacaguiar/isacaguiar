<?php
session_start();

$default_lang = 'en';
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $default_lang;
require_once "lang/$lang.php";

/**
 * Busca posts do WordPress via REST API com cache simples em arquivo.
 * Ajuste $wpBase se seu WP não estiver em /blog.
 */
function fetchLatestWpPosts($count = 3) {
  // Base do WP no mesmo domínio
  $wpPath = '/blog';

  // Monta URL absoluta (https + host atual)
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  $host   = $_SERVER['HTTP_HOST'] ?? 'isacaguiar.com.br';
  $base   = $scheme . '://' . $host . $wpPath;

  $cacheDir  = __DIR__ . '/assets/json';
  $cacheFile = $cacheDir . '/wp-latest-posts-cache.json';
  $cacheTtlSeconds = 30 * 60; // 30 min

  // Garante diretório do cache
  if (!is_dir($cacheDir)) {
    @mkdir($cacheDir, 0755, true);
  }

  // Cache válido?
  if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTtlSeconds)) {
    $cached = json_decode(@file_get_contents($cacheFile), true);
    if (is_array($cached)) return $cached;
  }

  $url = $base . "/wp-json/wp/v2/posts?per_page=" . intval($count) . "&_embed=1";

  $ctx = stream_context_create([
    'http' => [
      'method'  => 'GET',
      'timeout' => 6,
      'header'  => "Accept: application/json\r\nUser-Agent: isacaguiar-site\r\n"
    ],
    // Evita falhas bobas de SSL em hosts mal configurados (ideal é deixar true, mas isso resolve rápido)
    'ssl' => [
      'verify_peer' => true,
      'verify_peer_name' => true,
    ]
  ]);

  $raw = @file_get_contents($url, false, $ctx);

  if ($raw === false) {
    // Se falhar e existir cache antigo, usa o antigo
    if (file_exists($cacheFile)) {
      $cached = json_decode(@file_get_contents($cacheFile), true);
      if (is_array($cached)) return $cached;
    }
    return [];
  }

  $data = json_decode($raw, true);
  if (!is_array($data)) return [];

  $posts = [];
  foreach ($data as $p) {
    $title = isset($p['title']['rendered']) ? strip_tags($p['title']['rendered']) : 'Post';
    $link  = isset($p['link']) ? $p['link'] : '/blog/';
    $date  = isset($p['date']) ? substr($p['date'], 0, 10) : '';
    $excerpt = isset($p['excerpt']['rendered']) ? trim(strip_tags($p['excerpt']['rendered'])) : '';
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

  @file_put_contents($cacheFile, json_encode($posts, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
  return $posts;
}

$latestPosts = fetchLatestWpPosts(3);

// SEO básico (pode refinar depois)
$siteTitle = "Isac Aguiar — Java Backend • Arquitetura • Sistemas Distribuídos";
$siteDesc  = isset($content['description']) ? $content['description'] : "Backend Java, arquitetura, sistemas distribuídos e integrações críticas.";
$canonical = "https://isacaguiar.com.br/";
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo htmlspecialchars($siteTitle); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($siteDesc); ?>" />
  <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>" />

  <!-- Open Graph -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo htmlspecialchars($siteTitle); ?>" />
  <meta property="og:description" content="<?php echo htmlspecialchars($siteDesc); ?>" />
  <meta property="og:url" content="<?php echo htmlspecialchars($canonical); ?>" />
  <meta property="og:image" content="https://isacaguiar.com.br/assets/img/profile.jpg" />

  <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />

  <!-- Bootstrap (mantém CDN como você já usa no projeto) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS da home (novo) -->
  <link href="assets/css/home.css" rel="stylesheet" />

  <!-- GA (mantém o seu) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-XCB9J0HPCH"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-GSMMHGW5QX');
  </script>

  <!-- Schema Person -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "Isac Aguiar",
    "url": "https://isacaguiar.com.br/",
    "image": "https://isacaguiar.com.br/assets/img/profile.jpg",
    "jobTitle": "Backend Developer / Tech Lead",
    "sameAs": [
      "https://www.linkedin.com/in/isac-aguiar-0889178/",
      "https://github.com/isacaguiar"
    ]
  }
  </script>
</head>

<body>
  <!-- Top Nav -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/">Isac Aguiar</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
          <li class="nav-item"><a class="nav-link" href="#services"><?php echo ($lang === 'pt' ? 'Como posso ajudar' : 'How I can help'); ?></a></li>
          <li class="nav-item"><a class="nav-link" href="#projects"><?php echo ($lang === 'pt' ? 'Projetos' : 'Projects'); ?></a></li>
          <li class="nav-item"><a class="nav-link" href="#content"><?php echo ($lang === 'pt' ? 'Conteúdos' : 'Content'); ?></a></li>
          <li class="nav-item"><a class="nav-link" href="/blog/"><?php echo ($lang === 'pt' ? 'Blog' : 'Blog'); ?></a></li>
          <li class="nav-item"><a class="nav-link" href="cv.php"><?php echo ($lang === 'pt' ? 'Currículo' : 'Resume'); ?></a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <?php echo ($lang === 'pt' ? 'Idioma' : 'Language'); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="switch_language.php?lang=pt">Português</a></li>
              <li><a class="dropdown-item" href="switch_language.php?lang=en">English</a></li>
            </ul>
          </li>

          <li class="nav-item ms-lg-2">
            <a class="btn btn-primary btn-sm" target="_blank"
               href="https://api.whatsapp.com/send?phone=5571992227254&text=Ol%C3%A1%2C%20vi%20seu%20site%20e%20quero%20falar%20sobre%20um%20projeto.">
              <?php echo ($lang === 'pt' ? 'Falar no WhatsApp' : 'Chat on WhatsApp'); ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <header class="hero">
    <div class="container py-5">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <span class="badge text-bg-light border mb-3">
            <?php echo ($lang === 'pt' ? 'Java • Spring • Arquitetura • Integrações críticas' : 'Java • Spring • Architecture • Critical integrations'); ?>
          </span>

          <h1 class="display-5 fw-bold lh-1 mb-3">
            <?php echo ($lang === 'pt'
              ? 'Construo backends resilientes e escaláveis para sistemas de missão crítica.'
              : 'I build resilient, scalable backends for mission-critical systems.'
            ); ?>
          </h1>

          <p class="lead text-secondary mb-4">
            <?php echo ($lang === 'pt'
              ? 'Mais de 15 anos com Java/Spring, sistemas distribuídos, performance, mensageria e automação — com experiência em ambientes regulados.'
              : '15+ years with Java/Spring, distributed systems, performance, messaging and automation — experienced in regulated environments.'
            ); ?>
          </p>

          <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-primary" href="cv.php"><?php echo ($lang === 'pt' ? 'Ver currículo' : 'View resume'); ?></a>
            <a class="btn btn-outline-primary" href="/blog/"><?php echo ($lang === 'pt' ? 'Ler artigos' : 'Read articles'); ?></a>
            <a class="btn btn-outline-secondary" href="#content"><?php echo ($lang === 'pt' ? 'Últimos posts' : 'Latest posts'); ?></a>
          </div>

          <div class="mt-4 small text-secondary">
            <?php echo ($lang === 'pt'
              ? 'Foco atual: ofertas/fintech, arquitetura, observabilidade e performance.'
              : 'Current focus: fintech/offers, architecture, observability and performance.'
            ); ?>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="card shadow-sm border-0">
            <div class="card-body p-4">
              <div class="d-flex align-items-center gap-3">
                <img class="rounded-circle" src="assets/img/profile.jpg" alt="Isac Aguiar" width="72" height="72" />
                <div>
                  <div class="fw-bold">Isac Aguiar</div>
                  <div class="text-secondary small">
                    <?php echo ($lang === 'pt' ? 'Backend • Tech Lead • Arquitetura' : 'Backend • Tech Lead • Architecture'); ?>
                  </div>
                </div>
              </div>

              <hr />

              <ul class="list-unstyled mb-0 small">
                <li class="mb-2">✅ Java / Spring Boot / APIs</li>
                <li class="mb-2">✅ Resiliência (retry, circuit breaker, fallback)</li>
                <li class="mb-2">✅ Performance / SQL / Observabilidade</li>
                <li>✅ Mensageria (RabbitMQ) & integrações</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </header>

  <!-- SERVICES -->
  <section id="services" class="section">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <h2 class="h3 fw-bold"><?php echo ($lang === 'pt' ? 'Como posso ajudar' : 'How I can help'); ?></h2>
          <p class="text-secondary">
            <?php echo ($lang === 'pt'
              ? 'Uma home que converte precisa deixar claro “o que você faz” em 10 segundos.'
              : 'A high-converting homepage explains “what you do” in 10 seconds.'
            ); ?>
          </p>
        </div>

        <div class="col-lg-8">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <h3 class="h5 fw-semibold mb-2"><?php echo ($lang === 'pt' ? 'Arquitetura & evolução' : 'Architecture & evolution'); ?></h3>
                  <p class="text-secondary mb-0">
                    <?php echo ($lang === 'pt'
                      ? 'Clean/Hexagonal, DDD e pragmatismo para entregar com segurança.'
                      : 'Clean/Hexagonal, DDD and pragmatism to deliver safely.'
                    ); ?>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <h3 class="h5 fw-semibold mb-2"><?php echo ($lang === 'pt' ? 'Performance & estabilidade' : 'Performance & stability'); ?></h3>
                  <p class="text-secondary mb-0">
                    <?php echo ($lang === 'pt'
                      ? 'Investigação de gargalos, tuning e observabilidade orientada a métricas.'
                      : 'Bottleneck investigation, tuning and metrics-driven observability.'
                    ); ?>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <h3 class="h5 fw-semibold mb-2"><?php echo ($lang === 'pt' ? 'Integrações críticas' : 'Critical integrations'); ?></h3>
                  <p class="text-secondary mb-0">
                    <?php echo ($lang === 'pt'
                      ? 'APIs, mensageria e contratos bem definidos para reduzir incidentes.'
                      : 'APIs, messaging and solid contracts to reduce incidents.'
                    ); ?>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <h3 class="h5 fw-semibold mb-2"><?php echo ($lang === 'pt' ? 'Mentoria & revisão' : 'Mentoring & review'); ?></h3>
                  <p class="text-secondary mb-0">
                    <?php echo ($lang === 'pt'
                      ? 'Revisão de PRs, padrões e guia de boas práticas para o time.'
                      : 'PR reviews, standards and best-practice guidance for teams.'
                    ); ?>
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROJECTS (linka para seus projetos atuais) -->
  <section id="projects" class="section bg-light">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <div>
          <h2 class="h3 fw-bold mb-1"><?php echo ($lang === 'pt' ? 'Projetos em destaque' : 'Featured projects'); ?></h2>
          <p class="text-secondary mb-0"><?php echo ($lang === 'pt' ? 'Alguns trabalhos e estudos recentes.' : 'Some recent work and studies.'); ?></p>
        </div>
        <a class="btn btn-outline-secondary btn-sm" href="projects.php"><?php echo ($lang === 'pt' ? 'Ver todos' : 'See all'); ?></a>
      </div>

      <div class="row g-3">
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="fw-semibold mb-1">Backend Java / Spring</div>
              <div class="text-secondary small mb-3"><?php echo ($lang === 'pt' ? 'APIs, integrações e padrões.' : 'APIs, integrations and patterns.'); ?></div>
              <a class="link-primary" href="projects.php"><?php echo ($lang === 'pt' ? 'Explorar projetos →' : 'Explore projects →'); ?></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="fw-semibold mb-1"><?php echo ($lang === 'pt' ? 'Resiliência & performance' : 'Resilience & performance'); ?></div>
              <div class="text-secondary small mb-3"><?php echo ($lang === 'pt' ? 'Padrões e guias práticos.' : 'Patterns and practical guides.'); ?></div>
              <a class="link-primary" href="/blog/"><?php echo ($lang === 'pt' ? 'Ler no blog →' : 'Read on the blog →'); ?></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="fw-semibold mb-1"><?php echo ($lang === 'pt' ? 'Arquitetura limpa' : 'Clean architecture'); ?></div>
              <div class="text-secondary small mb-3"><?php echo ($lang === 'pt' ? 'Hexagonal/DDD na prática.' : 'Hexagonal/DDD in practice.'); ?></div>
              <a class="link-primary" href="/blog/"><?php echo ($lang === 'pt' ? 'Ver conteúdos →' : 'See content →'); ?></a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- CONTENT (últimos posts do WP) -->
  <section id="content" class="section">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <div>
          <h2 class="h3 fw-bold mb-1"><?php echo ($lang === 'pt' ? 'Últimos artigos' : 'Latest articles'); ?></h2>
          <p class="text-secondary mb-0"><?php echo ($lang === 'pt' ? 'Conteúdo técnico para gerar tráfego orgânico e prova de autoridade.' : 'Technical content to drive organic traffic and authority.'); ?></p>
        </div>
        <a class="btn btn-primary btn-sm" href="/blog/"><?php echo ($lang === 'pt' ? 'Ir para o blog' : 'Go to blog'); ?></a>
      </div>

      <div class="row g-3">
        <?php if (empty($latestPosts)): ?>
          <div class="col-12">
            <div class="alert alert-light border">
              <?php echo ($lang === 'pt'
                ? 'Não consegui carregar os posts agora. Você pode acessar direto em /blog.'
                : 'Could not load posts right now. You can go directly to /blog.'
              ); ?>
            </div>
          </div>
        <?php else: ?>
          <?php foreach ($latestPosts as $p): ?>
            <div class="col-md-6 col-lg-4">
              <a class="text-decoration-none text-reset" href="<?php echo htmlspecialchars($p['link']); ?>">
                <div class="card h-100 border-0 shadow-sm card-hover">
                  <?php if (!empty($p['img'])): ?>
                    <img src="<?php echo htmlspecialchars($p['img']); ?>" class="card-img-top" alt="">
                  <?php endif; ?>
                  <div class="card-body">
                    <div class="small text-secondary mb-2"><?php echo htmlspecialchars($p['date']); ?></div>
                    <div class="fw-semibold mb-2"><?php echo htmlspecialchars($p['title']); ?></div>
                    <div class="text-secondary small"><?php echo htmlspecialchars($p['excerpt']); ?></div>
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
  <section class="section bg-dark text-white">
    <div class="container">
      <div class="row align-items-center g-3">
        <div class="col-lg-8">
          <h2 class="h3 fw-bold mb-1"><?php echo ($lang === 'pt' ? 'Quer conversar sobre um projeto?' : 'Want to talk about a project?'); ?></h2>
          <p class="text-white-50 mb-0">
            <?php echo ($lang === 'pt'
              ? 'Me chama no WhatsApp e eu te respondo com os próximos passos.'
              : 'Message me on WhatsApp and I’ll reply with next steps.'
            ); ?>
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a class="btn btn-primary" target="_blank"
             href="https://api.whatsapp.com/send?phone=5571992227254&text=Ol%C3%A1%2C%20vi%20seu%20site%20e%20quero%20falar%20sobre%20um%20projeto.">
            <?php echo ($lang === 'pt' ? 'Abrir WhatsApp' : 'Open WhatsApp'); ?>
          </a>
        </div>
      </div>
    </div>
  </section>

  <footer class="py-4 border-top">
    <div class="container d-flex flex-wrap gap-2 justify-content-between align-items-center">
      <div class="small text-secondary">© <?php echo date('Y'); ?> Isac Aguiar</div>
      <div class="small">
        <a class="text-decoration-none me-3" href="cv.php"><?php echo ($lang === 'pt' ? 'Currículo' : 'Resume'); ?></a>
        <a class="text-decoration-none me-3" href="/blog/">Blog</a>
        <a class="text-decoration-none" href="https://github.com/isacaguiar" target="_blank">GitHub</a>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>