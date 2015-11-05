<?php
/*
	Template Name: Debug Home
*/
?>
<?php get_header(); ?>

<div class="container">
	<div id="main-content">
		<div id="debug-menu"><?php wp_nav_menu(array('menu' => 'debug_home_menu')); ?></div>
	</div>
</div>

<?php get_footer(); ?>