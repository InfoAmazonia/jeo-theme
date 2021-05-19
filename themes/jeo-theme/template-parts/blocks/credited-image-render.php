<?php 
$block_params = get_query_var('block_params');
$media_id = $block_params['mediaID'];
$media_url = $block_params['mediaURL'];
$align = $block_params['align'];
$old_content = $block_params['oldContent'];

$old_block_element = $old_content->getElementsByTagName('span');
$old_title = false;
$old_description = false;

if(sizeof($old_block_element) >= 1) {
    $old_block_element = $old_block_element[0];
    $old_title = $old_block_element->getAttribute('title');
    $old_description = $old_block_element->getAttribute('mediadescription');

    // var_dump($old_title);
    // var_dump($old_description);
}

?>

<?php if(!empty($media_id)): ?>
<div class="credited-image-block align<?= $align ?>">
    <div class="image-wrapper">
    <img src="<?= $media_url ?>" />
    <div class="image-info-wrapper">
        <span class="image-meta">
            <?php
            if (class_exists('Newspack_Image_Credits')) {
                $image_meta = Newspack_Image_Credits::get_media_credit($media_id); 
                
                if(empty($image_meta['credit']) && empty($image_meta['organization'])) {
                    echo $old_description;
                }

                ?>
                
                <?= (isset($image_meta['credit_url']) && !empty($image_meta['credit_url'])) ? '<a href="' . $image_meta['credit_url'] . '">' : null ?>
                <span class="credit">
                    <?= $image_meta['credit'] ?>

                    <?= isset($image_meta['organization']) && !empty($image_meta['organization']) ? ' / ' . $image_meta['organization'] : null ?>
                </span>
                <?= (isset($image_meta['credit_url']) && !empty($image_meta['credit_url'])) ? '</a>' : null ?>

            <?php
            }
            ?>
        </span>
        <span class="image-description-toggle">
            <i class="fas fa-camera"></i>
            <i class="fas fa-times"></i>
        </span>
    </div>
    </div>
    <div class="image-description">
        <?php 
            $media_legend = wp_get_attachment_caption( $media_id );

            if(empty($media_legend) && $old_title && !empty($old_title)):
                echo $old_title;
            else:
                echo $media_legend;
            endif;
        ?>
    </div>
</div>
<?php endif; ?>