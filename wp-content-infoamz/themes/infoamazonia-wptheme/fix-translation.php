<?php /* Template Name: FixTranslation */ ?>
<?php
include_once("wp-config.php");
include_once("wp-includes/wp-db.php");

$sql = "SELECT ID, guid, post_title, post_date, post_modified FROM wp_posts
WHERE ((post_date >= '2019-04-01 00:00:00' AND post_date <= '2020-01-31 23:59:59')
OR (post_modified >= '2019-04-01 00:00:00' AND post_modified <= '2020-01-31 23:59:59'))
AND (post_title LIKE '(Español)%') OR (post_title LIKE '(Português)%')
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
