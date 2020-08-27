<?php
    $isRepublishablePost = get_post_meta(get_the_ID(), 'republish_post', true);
?>
<?php if($isRepublishablePost): ?>
    <div class="republish-post">
        <div class="republish-post-label-wrapper">
            <div class="republish-post-label">
                <i class="fa fa-retweet icon" aria-hidden="true"></i>
                <p class="text"><?php esc_html_e('REPUBLISH THIS CONTENT'); ?></p>
            </div>
        </div>
        <div class="modal-container">
            <div class="republish-post-modal shadow">
                <div class="main-modal">
                    <button class="close-button">close</button>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>