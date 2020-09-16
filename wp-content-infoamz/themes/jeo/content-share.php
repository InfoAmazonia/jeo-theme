<?php
$page_title = __('Share a map', 'jeo');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<?php // by mohjak 2020-07-24: fixed comment https://tech.openinfo.cc/earth/infoamazonia/-/issues/8#note_8471 ?>
<title><?php echo "$page_title | "; bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.ico" type="image/x-icon" />
<?php wp_head(); ?>
</head>
<body <?php body_class(get_bloginfo('language')); ?>>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=459964104075857";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<header id="masthead">
		<div class="regular-header">
			<div class="container">
				<div class="three columns">
					<?php
					$lang = '';
					if(function_exists('qtranxf_getLanguage'))
						$lang = qtranxf_getLanguage();
					?>
					<h1>
						<a href="<?php echo home_url('/' . $lang); ?>" title="<?php echo bloginfo('name'); ?>"><span><?php bloginfo('name'); ?></span> <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png" class="logo" /></a>
					</h1>
				</div>
				<?php /*
				<div class="four columns">
					<?php get_search_form(); ?>
				</div>
				*/ ?>
				<div class="nine columns">
					<section id="mastnav" class="clearfix">
						<nav>
							<ul>
								<?php wp_nav_menu(array(
									'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<!--<li><a href="#submit" class="submit-story">' . __('Submit a story', 'infoamazonia') . '</a></li>--></ul>'
								)); ?>
							</ul>
						</nav>
					</section>
				</div>
			</div>
		</div>
		<?php if(is_singular('post')) : ?>
			<div class="single-post-header scrolled-header">
				<div class="container">
					<div class="two columns">
						<span class="site-logo">
							<a href="<?php echo home_url('/' . $lang); ?>" title="<?php echo bloginfo('name'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png" class="logo" /></a>
						</span>
					</div>
					<div class="seven columns">
						<span class="post-title"><span class="publisher"><?php echo get_the_term_list($post->ID, 'publisher', '', ', ', ': '); ?></span><?php the_title(); ?></span>
					</div>
					<div class="three columns">
						<span class="post-actions">
							<a href="javascript:void(0);" class="toggle-top-map"><span class="lsf">&#xE08b;</span> <?php _e('View map', 'infoamazonia'); ?></a>
						</span>
					</div>
				</div>
			</div>
			<div id="top-map">
				<?php jeo_map(); ?>
			</div>
		<?php endif; ?>
	</header>
	<section id="subnav">
		<div class="container">
			<div class="twelve columns">
				<div class="subnav-container">
					<div class="subnav-content">
						<?php if(function_exists('qtranxf_getLanguage')) : ?>
							<nav id="langnav">
								<ul>
									<?php
									global $q_config;
									if(is_404()) $url = get_option('home'); else $url = '';
									$current = qtranxf_getLanguage();
									foreach($q_config['enabled_languages'] as $language) {
										$attrs = '';
										if($language == $current)
											$attrs = 'class="active"';
										echo '<li><a href="' . qtranxf_convertURL($url, $language) . '" ' . $attrs . '>' . $language . '</a></li>';
									}
									?>
								</ul>
							</nav>
						<?php endif; ?>
						<nav id="social">
							<ul>
								<li class="twitter">
									<a href="https://twitter.com/infoamazonia" rel="external" target="_blank" title="Twitter"></a>
								</li>
								<li class="fb">
									<a href="https://www.facebook.com/infoamazonia" rel="external" target="_blank" title="Facebook"></a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="main-content">

<?php
$page_title = __('Share a map', 'jeo');
$map = false;
if(isset($_GET['map_id']) && $_GET['map_id']) {
	$map = get_post($_GET['map_id']);
	if($map && get_post_type($map->ID) == 'map')
		$page_title = __('Share', 'jeo') . ' ' . get_the_title($map->ID);
	else
		$map = false;
}

// All maps
$maps = get_posts(array('post_type' => 'map', 'posts_per_page' => -1));

// Single map
if(!$map && count($maps) <= 1) {
	$map = array_shift($maps);
	$page_title = __('Share the map', 'jeo');
}

// check for layer count

$allow_layers = true;
$layers = false;

if($allow_layers) {
	if(isset($_GET['layers'])) {
		$layers = explode(',', $_GET['layers']);
	} elseif($map) {
		$layers = jeo_get_map_layers($map->ID);
		if(count($layers) <= 1) {
			$layers = false;
		}
	}
}

// post
$post_id = false;
if(isset($_GET['p']))
	$post_id = $_GET['p'];

// share url
if($post_id) {
	$share_url = jeo_get_share_url(array('p' => $post_id));
} else {
	$share_url = jeo_get_share_url();
}
?>

<section id="content" class="share-page">
	<header class="page-header">
		<div class="container">
			<div class="twelve columns">
				<h1><?php echo $page_title; ?></h1>
			</div>
		</div>
	</header>
	<div id="jeo-share-widget">
		<div id="configuration">
			<div class="container row">
				<?php

				if(count($maps) > 1 || ($map && $layers)) :
					?>
					<div class="section layer three columns">
						<div class='inner'>
							<?php if(!$map) : ?>
								<h4>
									<?php _e('Choose a map', 'jeo'); ?>
									<a class='tip' href='#'>
										?
										<span class="popup arrow-left">
											<?php _e('Choose any map from the list', 'jeo'); ?>
										</span>
									</a>
								</h4>
								<div id='maps'>
									<select id="map-select" data-placeholder="<?php _e('Select a map', 'jeo'); ?>" class="chzn-select">
										<?php foreach($maps as $map) : ?>
											<option value="<?php echo $map->ID; ?>"><?php echo get_the_title($map->ID); ?></option>
										<?php endforeach; ?>
									</select>
									<?php if($allow_layers) : ?>
										<a href="#" class="select-map-layers" style="display:block;margin-top:5px;"><?php _e('Select layers from this map', 'jeo'); ?></a>
									<?php endif; ?>
								</div>
							<?php elseif($map && $layers) : ?>
								<?php $map_id = $map->ID; ?>
								<h4>
									<?php if(!isset($_GET['layers'])) : ?>
										<?php echo __('Select layers', 'jeo'); ?>
									<?php else : ?>
										<?php _e('Select layers', 'jeo'); ?>
									<?php endif; ?>
									<a class="tip" href="#">
										?
										<span class="popup arrow-left">
											<?php _e('Choose any layers from the list', 'jeo'); ?>
										</span>
									</a>
								</h4>
								<div id="maps">
									<?php if($layers) : ?>
										<select id="layers-select" data-placeholder="<?php _e('Select layers', 'jeo'); ?>" data-mapid="<?php echo $map_id; ?>" class="chzn-select" multiple>
											<?php foreach($layers as $layer) : ?>
												<?php
												if(!is_array($layer)) :
													$l = array('id' => $layer, 'title' => $layer);
													$layer = $l;
												endif;
												?>
												<option value="<?php echo $layer['id']; ?>" selected><?php if($layer['title']) : echo $layer['title']; else : echo $layer['id']; endif; ?></option>
											<?php endforeach; ?>
										</select>
									<?php endif; ?>
									<a class="clear-layers" href="#"><?php _e('Back to default layer configuration', 'jeo'); ?></a>
									<?php if(count($maps) > 1) : ?>
										<p><a class="button" href="<?php echo $share_url; ?>"><?php _e('View all maps', 'jeo'); ?></a></p>
									<?php endif; ?>
								</div>
							<?php else : ?>
								<h4>&nbsp;</h4>
								<input type="hidden" id="map_id" name="map_id" value="<?php echo $map->ID; ?>" />
								<p><a class="button" href="<?php echo $share_url; ?>"><?php _e('View all maps', 'jeo'); ?></a></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php
				$taxonomies = jeo_get_share_widget_taxonomies();
				?>

				<div class="section two columns">
					<div class="inner">
						<h4>
							<?php _e('Filter content', 'jeo'); ?>
							<a class="tip" href="#">
								?
								<span class="popup arrow-left">
									<?php _e('Filter the content displayed on the map through our options', 'jeo'); ?>
								</span>
							</a>
						</h4>
						<div id="map-content">
							<select id="content-select" data-placeholder="<?php _e('Select content', 'jeo'); ?>" class="chzn-select">
								<?php
								if(isset($_GET['p'])) :
									$post = get_post($_GET['p']);
									if($post) : ?>
										<optgroup label="<?php _e('Selected content', 'jeo'); ?>">
											<option value="post&<?php echo $post->ID; ?>" selected><?php echo get_the_title($post->ID); ?></option>
										</optgroup>
									<?php endif; ?>
								<?php endif; ?>
								<optgroup label="<?php _e('General content', 'jeo'); ?>">
									<option value="latest"><?php if(!isset($_GET['map_id'])) _e('Content from the map', 'jeo'); else _e('Latest content', 'jeo'); ?></option>
									<option value="map-only"><?php _e('No content (map only)', 'jeo'); ?></option>
								</optgroup>
								<?php foreach($taxonomies as $taxonomy) :
									$taxonomy = get_taxonomy($taxonomy);
									if($taxonomy) :
										$terms = get_terms($taxonomy->name);
										if($terms) :
											?>
											<optgroup label="<?php echo __('By', 'jeo') . ' ' . strtolower($taxonomy->labels->name); ?>">
												<?php foreach($terms as $term) : ?>
													<option value="tax_<?php echo $taxonomy->name; ?>&<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
												<?php endforeach; ?>
											</optgroup>
										<?php
										endif;
									endif;
								endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<div class='section size three columns'>
					<div class='inner'>
						<h4>
							<?php _e('Width & Height', 'jeo'); ?>
							<a class='tip' href='#'>
								?
								<span class="popup arrow-left">
									<?php _e('Select the width and height proportions you would like to embed to be.', 'jeo'); ?>
								</span>
							</a>
						</h4>
						<ul id='sizes' class='sizes clearfix'>
							<li><a href='#' data-size='small' data-width='480' data-height='300'><?php _e('Small', 'jeo'); ?></a></li>
							<li><a href='#' data-size='medium' data-width='600' data-height='400'><?php _e('Medium', 'jeo'); ?></a></li>
							<li><a href='#' data-size='large' data-width='960' data-height='480' class='active'><?php _e('Large', 'jeo'); ?></a></li>
						</ul>
					</div>
				</div>

				<div class='section output two columns'>
					<div class='inner'>
						<h4>
							<div class='popup arrow-right'>
							</div>
							<?php _e('HTML Output', 'jeo'); ?>
							<a class='tip' href='#'>
								?
								<span class="popup arrow-left">
									<?php _e('Copy and paste this code into an HTML page to embed with it\'s current settings and location', 'jeo'); ?>
								</span>
							</a>
						</h4>
						<textarea id="output"></textarea>
                        <div class="sub-inner">
                            <h5>
                                <div class='popup arrow-right'>
                                </div>
                                <?php _e('URL', 'jeo'); ?>
                                <a class='tip' href='#'>
                                    ?
                                    <span class="popup arrow-left">
                                        <?php _e('Get the original to use as a link or a custom embed.', 'jeo'); ?>
                                    </span>
                                </a>
                            </h5>
                            <input type="text" id="url-output" />
                        </div>
					</div>
				</div>

				<div class="section social two columns">
					<div class="inner">
						<h4>
							<div class="popup arrow-right">
							</div>
							<?php _e('Share', 'jeo'); ?>
							<a class="tip" href="#">
								?
								<span class="popup arrow-left">
									<?php _e('Share this map, with it\'s current settings and location, on your social network', 'jeo'); ?>
								</span>
							</a>
						</h4>
					</div>
					<p id="jeo-share-social" class="links">
						<a href="#" class="facebook"><span class="lsf">&#xE047;</span></a>
						<a href="#" class="twitter"><span class="lsf">&#xE12f;</span></a>
					</p>
				</div>

			</div>
		</div>

		<div class="container">
			<div class="twelve columns">
				<h2 class="preview-title"><?php _e('Map preview', 'jeo'); ?></h2>
			</div>
		</div>
		<div id="embed-container">
			<div class="content" id="widget-content">
				<!-- iframe goes here -->
			</div>
		</div>

	</div>
</section>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		jeo_share_widget.controls();
	});
</script>

<?php get_footer(); ?>
