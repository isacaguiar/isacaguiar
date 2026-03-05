<!-- Experience-->
<section class="resume-section" id="experience">
    <div class="resume-section-content">
        <h2 class="mb-5"><?php echo $content['experience']['title']; ?></h2>
        
        <?php foreach ($content['experience']['jobs'] as $job): ?>
            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="flex-grow-1">
                    <h3 class="mb-0"><?php echo $job['title']; ?></h3>
                    <div class="subheading mb-0">
                        <a href="<?php echo $job['link']; ?>" target="_blank"><?php echo $job['company']; ?></a> - <?php echo $job['period']; ?>
                    </div>
                    <h4 class="mb-0"><?php echo $job['position']; ?></h4>
                    <div class="card bg-dark">
                    <div class="card-body">
                        <?php echo $job['notes']; ?>
                    </div>
                    </div>
                    
                </div>
                <!--div class="flex-shrink-0"><span class="text-primary"><?php echo $job['period']; ?></span></div-->
            </div>
        <?php endforeach; ?>

    </div>
</section>