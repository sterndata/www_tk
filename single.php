<?php
/**
 * The Template for displaying all single posts.
 *
 * @package _sds
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
        <?php
          $format = 'single';
          if ( $thisone= get_post_format() ) $format = $thisone;
          get_template_part( 'content', $format ); ?>

		<?php _sds_content_nav( 'nav-below' ); ?>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		?>

	<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
