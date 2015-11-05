<?php
/*
	Template Name: Account
*/
?>
<?php get_header(); ?>
<?php
    $current_user = wp_get_current_user();
    $current_user_meta = get_user_meta($current_user->ID);
?>
<div class="container">
	<div id="main-content">
		<pre><?php echo print_r($current_user_meta, true); ?></pre>
	</div>
</div>

<?php get_footer(); ?>