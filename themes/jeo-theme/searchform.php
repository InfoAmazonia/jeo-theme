<?php

/**
 * Template for displaying search forms.
 *
 * @package Newspack
 */

$unique_id = wp_unique_id('search-form-');
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label for="<?php echo esc_attr($unique_id); ?>">
		<span class="screen-reader-text"><?php echo esc_html_x('Search for:', 'label', 'newspack'); ?></span>
	</label>
	<div class="search-input-wrapper">
		<input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'newspack'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<button type="submit" class="search-submit">
			<?php echo wp_kses(newspack_get_icon_svg('search', 28), newspack_sanitize_svgs()); ?>
			<span class="screen-reader-text">
				<?php echo esc_html_x('Search', 'submit button', 'newspack'); ?>
			</span>
		</button>
	</div>


	<div class="filters">
		<h5 class="filters--title"> Filters </h5>
		<div class="filters--itens">
			<div class="filters--item">
			<input type="text" value="<?= isset($_GET['daterange']) || !empty($_GET['daterange'])? $_GET['daterange'] : 'Date range' ?>" replace-empty="<?= !isset($_GET['daterange']) || empty($_GET['daterange'])? 'true' : 'false' ?>" placeholder="Date range" name="daterange">
			</div>

			<div class="filters--item">
				<select name="topic" id="topic">
					<option value=""> Topics </option>
					<?php
					$terms = get_terms("topic");

					foreach ($terms as $term) : ?>
						<option value="<?= $term->slug ?>" <?= isset($_GET['topic']) && $_GET['topic'] == $term->slug ? 'selected' : '' ?>> <?= $term->name ?> </option>

					<?php endforeach; ?>
				</select>
			</div>

			<div class="filters--item">
				<select name="region" id="region">
					<option value=""> Regions </option>
					<?php
					$terms = get_terms("region");

					foreach ($terms as $term) : ?>
						<option value="<?= $term->slug ?>" <?= isset($_GET['region']) && $_GET['region'] == $term->slug ? 'selected' : '' ?>> <?= $term->name ?> </option>

					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
</form>