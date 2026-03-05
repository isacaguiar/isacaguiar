<!-- Education -->
<section class="resume-section" id="education">
    <div class="resume-section-content">
        <h2 class="mb-5"><?php echo $content['education']['title']; ?></h2>
        <?php foreach ($content['education']['formations'] as $item): ?>
            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="flex-grow-1">
                    <h3 class="mb-0"><a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['degree']; ?></a></h3>
                    <div class="subheading mb-0">
                        <?php echo $item['institution']; ?>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <span class="text-primary"><?php echo $item['period']; ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
