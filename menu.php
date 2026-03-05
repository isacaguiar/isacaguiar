<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top overflow-auto" id="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="index.php#page-top">
        <span class="d-block d-lg-none">Isac Aguiar</span>
        <span class="d-none d-lg-block"><img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="assets/img/profile.jpg" alt="" /></span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">SOBRE</a></li-->
            <!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#experience">EXPERIENCE</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#education">FORMATION</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#skills">SKILLS</a></li-->
            <!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="#interests">INTERESSES</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#projects">PROJETOS</a></li-->   
            <!--li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#awards">COURSES</a></li>   
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="projects.php#projects">PROJECTS</a></li>   
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="http://www.isacaguiar.com.br/blog/">ARTICLES</a></li-->
            <li class="mb-2">
                <div>
                    <a href="switch_language.php?lang=en">English</a> |
                    <a href="switch_language.php?lang=pt">Português</a>
                </div>
            </li>
            <?php foreach ($content['nav']['itens'] as $item): ?>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a>
                </li>
            <?php endforeach; ?>
            <li>
                <a class="nav-link js-scroll-trigger" href="http://www.novemax.com.br/" target="_blank">
                    <img src="assets/img/logo_novemax.png" alt="" />
                </a>
            </li>
        </ul>
    </div>
</nav>