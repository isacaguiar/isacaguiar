<!-- Projects -->
<section class="resume-section" id="projects">
    <div class="resume-section-content">
            
        <h2 class="mb-5"><?php echo $content['projects']['title']; ?></h2>

        <div class="row">
            <?php foreach ($content['projects']['itens'] as $project): ?>
            
                <div class="col-sm-4 mb-3">
                    <div class="card">
                        <img src="<?php echo $project['image']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $project['project']; ?></h5>
                            <p class="card-text"><?php echo $project['description']; ?></p>
                            <p class="card-text"><?php echo $project['technologies']; ?></p>
                            <?php if (!empty($project['links'])): ?>
                                <?php foreach ($project['links'] as $link): ?>
                                    <a href="<?php echo $link; ?>" target="_blank" class="card-link text-dark  mb-0">
                                        <i class="fas fa-external-link-alt fa-2x"></i></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>