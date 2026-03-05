<!-- Awards-->
<!-- Certifications and awards -->
<section class="resume-section" id="awards">
    <div class="resume-section-content">
        <h2 class="mb-5"><?php echo $content['awards']['title']; ?></h2>

        <?php foreach ($content['awards']['courses'] as $award): ?>
        <div class="d-flex flex-column flex-md-row justify-content-between mb-5">

            <ul class="list-unstyled fa-ul mb-0 p-2">
                
                    <li class="mb-0 h4">
                        <span class="fa-li h3">
                            <i class="fas <?php echo $award['icon']; ?> text-warning" title="<?php echo $award['icon_title']; ?>"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h3 class="mb-0"><a href="<?php echo $award['link']; ?>" target="_blank"><?php echo $award['course']; ?></a></h3>
                            <div class="subheading mb-0"><?php echo $award['institution']; ?></div>
                            <p class="mb-0"><?php echo $award['duration']; ?> | <?php echo $award['year']; ?></p>
                        </div>
                    </li>
                
            </ul>

        </div>
        <?php endforeach; ?>


    </div>
</section>
