<?php
/**
 * Sidebar template
 *
 * @package Workstation
 * @since 1.0.0
 */

?>
<aside id="secondary" class="sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'workstation' ); ?>">
	<?php
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		dynamic_sidebar( 'sidebar-1' );
	}
	?>
</aside>
