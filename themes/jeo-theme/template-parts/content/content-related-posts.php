<?php
$posts = guaraci\related_posts::get_posts(get_the_ID(), 3)->posts;
?>
<?php if (sizeof($posts) >= 3 && sizeof($posts) != 0 && get_option('related_posts__use', false)) : ?>
    <div class="related-posts">
        <p class="title-section"><?= __('Related Posts', 'jeo') ?></p>

        <div class="posts">
            <?php foreach ($posts as $key => $value) : ?>
                <div class="post">
                    <?php if (get_the_post_thumbnail($value->ID)) : ?>
                        <div class="thumbnail">
                            <a class="thumbnail-inner" href="<?php echo get_permalink($value->ID) ?>" target="blank">
                                <?php echo get_the_post_thumbnail($value->ID) ?>
                            </a>
                        </div>
                    <?php endif ?>
                    <div class="entry-container">
                        <p class="title">
                            <a href="<?php echo get_permalink($value->ID) ?>" target="blank">
                                <?php echo $value->post_title ?>
                            </a>
                        </p>
                        <p class="date"><?php echo get_the_time('F j, Y', $value->ID); ?></p>
                        <p class="excerpt"><?php echo get_the_excerpt($value->ID) ?></p>
                    </div>
                </div>
                <?php if ($key >= 2) break; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif ?>