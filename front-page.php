<?php
/**
 * The template for displaying the Finesse Front Page
 *
 * @package Workstation
 * @since 1.0.0
 */

get_header();
?>

<main id="main" class="site-main" role="main">
	<?php
	// Section 2: Hero
	get_template_part( 'template-parts/finesse/hero' );

	// Section 3: About Intro
	get_template_part( 'template-parts/finesse/intro' );

	// Section 4: Key Statistics
	get_template_part( 'template-parts/finesse/stats' );

	// Section 5: Services Index
	get_template_part( 'template-parts/finesse/services-index' );

	// Sections 6-8: Interactive 3D Service Explorer & Process
	get_template_part( 'template-parts/finesse/explorer' );

	// Section 9: Before/After Concrete Grinding Slider
	get_template_part( 'template-parts/finesse/compare' );

	// Section 10: Full-Bleed Feature Image
	get_template_part( 'template-parts/finesse/fullbleed' );

	// Section 11: Recent Projects Grid
	get_template_part( 'template-parts/finesse/projects' );

	// Section 12: Contact Form & Info
	get_template_part( 'template-parts/finesse/contact' );
	?>
</main>

<?php
get_footer();
