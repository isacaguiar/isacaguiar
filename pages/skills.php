<!-- Skills -->
<section class="resume-section" id="skills">
    <div class="resume-section-content">
        <h2 class="mb-5"><?php echo $content['skills']['title']; ?></h2>
        <?php foreach ($content['skills']['categories'] as $category): ?>
            <h3 class="mb-0"><?php echo $category['name']; ?></h3>
            <ul class="list-unstyled fa-ul mb-0 p-2">
                <?php foreach ($category['itens'] as $item): ?>
                    <li class="mb-2 h4">
                        <span class="fa-li h3">
                            <i class="<?php echo $item['icon']; ?> text-warning" title="<?php echo $item['icon_title']; ?>"></i>
                        </span>
                        <?php echo $item['name']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    </div>
</section>
