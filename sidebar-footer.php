<?php
/**
 * The sidebar containing the main widget area
 *
 * @package _sds
 */
?>


	<div class="sidebar col-sm-12 col-md-12">

		<?php // add the class "panel" below here to wrap the sidebar in Bootstrap style ;) ?>
		<div class="sidebar-padder">

			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( 'footer' ) ) : ?>
			<?php endif; ?>

		</div><!-- close .sidebar-padder -->
