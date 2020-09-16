<?php /* Template Name: FixTitles */ ?>
<?php
include_once("wp-config.php");
include_once("wp-includes/wp-db.php");

$sql = "SELECT ID, guid, post_title, post_date, post_modified FROM wp_posts
    WHERE (1 = 1
        AND (1 = 0
            OR post_date <= '2016-08-01 00:00:00'
            OR post_modified <= '2016-08-01 00:00:00'
        )
        AND post_type = 'post'
        AND post_status = 'publish'
        AND (1 = 0
            OR post_title NOT LIKE '%:es%'
            OR post_title NOT LIKE '%:en%'
            OR post_title NOT LIKE '%:pt%'
        )
    )
;";

$results = $wpdb->get_results($sql);
echo count($results);
echo '<br>';
?>

<ul>
<?php foreach ($results as $value) { ?>
  <li>
    <a href="https://infoamazonia.org/wp-admin/post.php?post=<?php echo $value->ID; ?>&action=edit"><?php echo $value->post_title; ?></a>
  </li>
<?php } ?>
</ul>
