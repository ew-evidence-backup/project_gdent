<?php get_header(); ?>

<div class="container">

<div id="main-content" class="form-horizontal">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; else : endif; ?>
</div>
<?php gf_debug(false); ?>

</div>

<?php get_footer(); ?>