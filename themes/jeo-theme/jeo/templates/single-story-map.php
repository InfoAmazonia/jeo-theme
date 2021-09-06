<?php
?>

<?php
	get_header('single'); 
	the_post();
?>

<div class="content">
	<?php the_content(); ?>
</div>

<?php get_footer(); ?>